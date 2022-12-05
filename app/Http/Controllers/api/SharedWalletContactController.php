<?php

namespace App\Http\Controllers\api;

use App\CustomerContact;
use App\Group;
use App\GroupMember;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SharedWallet\AddContactRequest;
use App\Http\Requests\SharedWallet\AddGroupRequest;
use App\Http\Requests\SharedWallet\AddNewMembersRequest;
use App\Http\Requests\SharedWallet\DeleteContactRequest;
use App\Http\Requests\SharedWallet\DeleteGroupRequest;
use App\Http\Requests\SharedWallet\DeleteMemberRequest;
use App\Http\Requests\SharedWallet\EditContactRequest;
use App\Http\Requests\SharedWallet\EditGroupRequest;
use App\Models\Customer;
use App\SharedWalletContact;
use App\traits\ResonseTrait;
use Illuminate\Http\Request;

class SharedWalletContactController extends Controller
{
    use ResonseTrait;
    public function AddContactToSharedWallet(AddContactRequest $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $contactId = CustomerContact::select('contact_id', 'customer_id')->where('id', $request->customer_contact_id)->first();
            $SharedWalletContact = SharedWalletContact::where('customer_contact_id', $request->customer_contact_id)->first();
            if ($SharedWalletContact && $customer->id == $contactId->customer_id) {
                return $this->returnError("تم اضافته من قبل");
            }
            $SharedWalletContact =
                SharedWalletContact::create([
                    'customer_contact_id' => $request->customer_contact_id,
                    'contact_id' => $contactId->contact_id,
                    'limit' => $request->limit,
                    'limit_value' => $request->limit_value,
                ]);
            return $this->returnData($SharedWalletContact, "تم إضافة رقم الي المحفظة المشتركة بنجاح");
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function EDitContactInSharedWallet(EditContactRequest $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $contact = SharedWalletContact::where('id', $request->shared_wallet_contact_id)->first();
            if ($contact) {
                $contact->limit = $request->limit;
                $contact->limit_value = $request->limit_value;
                $contact->save();
                return $this->returnData($contact, "تم تعديل بيانات جهة الاتصال بنجاح");
            } else {
                return $this->returnError("This id not found");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function DeleteContactFromSharedWallet(DeleteContactRequest $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $contact = SharedWalletContact::where('id', $request->shared_wallet_contact_id)->first();
            if ($contact) {
                $contact->delete();
                return $this->returnData([], "تم المسح بنجاح");
            } else {
                return $this->returnError("This id not found");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function getSharedWalletContacts(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));

        if ($customer) {
            $customerContacts = CustomerContact::where('customer_id', $customer->id)->pluck('id');
            $sharedContacts = SharedWalletContact::select('shared_wallet_contacts.id', 'shared_wallet_contacts.limit', 'shared_wallet_contacts.limit_value', 'customer_contacts.contact_id', 'customers.image', 'customer_contacts.phone', 'customer_contacts.full_name')
                ->leftjoin('customer_contacts', 'customer_contacts.id', 'shared_wallet_contacts.customer_contact_id')
                ->leftjoin('customers', 'customers.id', 'shared_wallet_contacts.contact_id')
                ->whereIn('shared_wallet_contacts.customer_contact_id', $customerContacts)
                ->get();

            return $this->returnData($sharedContacts, "تم الحصول على الداتا بنجاح");
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function AddGroup(AddGroupRequest $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $group =
                Group::create([
                    'customer_id' => $customer->id,
                    'group_name' => $request->group_name,
                    'limit' => $request->limit,
                    'limit_value' => $request->limit_value,
                ]);
            foreach ($request->members as  $key => $value) {
                $Contact = CustomerContact::select('contact_id')->where('id', $value)->first();
                $member = new GroupMember();
                $member->group_id = $group->id;
                $member->customer_contact_id = $value;
                $member->contact_id = $Contact->contact_id;
                $member->save();
            }

            return $this->returnData([],"تم إنشاء مجموعة جديدة بنجاح");
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function UpdateGroup(EditGroupRequest $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $group = Group::where('id', $request->group_id)->where('customer_id', $customer->id)->first();
            $group->update([
                'group_name' => $request->group_name,
                'limit' => $request->limit,
                'limit_value' => $request->limit_value,
            ]);

            return $this->returnData([],"تم تعديل  إعدادات المجموعة بنجاح");
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function AddNewMembersToGroup(AddNewMembersRequest $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $group = Group::where('id', $request->group_id)->where('customer_id', $customer->id)->first();
            foreach ($request->members as  $key => $value) {
                $Contact = CustomerContact::select('contact_id')->where('id', $value)->first();
                $member = new GroupMember();
                $member->group_id = $group->id;
                $member->customer_contact_id = $value;
                $member->contact_id = $Contact->contact_id;
                $member->save();
            }
            return $this->returnData([],"تم إضافة أعضاء إلي المجموعة بنجاح");
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function DeleteGroup(DeleteGroupRequest $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $group = Group::where('id', $request->group_id)->first();
            $groupMembers = GroupMember::where('group_id', $group->id)->get();
            if ($group) {
                $group->delete();
                foreach ($groupMembers as $member) {
                    $member->delete();
                }
                return $this->returnData([], "تم المسح بنجاح");
            } else {
                return $this->returnError("This id not found");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function getSharedWalletGroups(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $groups = Group::select('id', 'group_name')->where('customer_id', $customer->id)->get();
            return $this->returnData($groups, "تم الحصول على الداتا بنجاح");
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function showGroup(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $group = Group::select('id', 'group_name', 'limit', 'limit_value')
                ->where('id', $request->group_id)
                ->where('customer_id', $customer->id)
                ->first();
            $group_members = GroupMember::select('group_members.id as group_member_id','group_members.customer_contact_id','customer_contacts.id as customer_contact_id','customer_contacts.phone','customer_contacts.full_name','customers.image')
            ->leftjoin('customer_contacts','customer_contacts.id','group_members.customer_contact_id')
            ->leftjoin('customers','customers.id','customer_contacts.contact_id')
            ->where('group_members.group_id',$group->id)
            ->get();
            $group->group_members = $group_members;
            return $this->returnData($group, "تم الحصول على الداتا بنجاح");
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function DeleteMember(DeleteMemberRequest $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $group = Group::where('id', $request->group_id)->where('customer_id', $customer->id)->first();
            if ($group) {
                $member = GroupMember::where('group_id', $group->id)->where('id', $request->group_member_id)->first();
                if($member) {
                    $member->delete();
                    return $this->returnData([], "تم المسح بنجاح");
                } else {
                    return $this->returnError("This member not found");
                }
            } else {
                return $this->returnError("This group not found");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function getAllSharedWalletLists(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $customerContacts = CustomerContact::where('contact_id', $customer->id)->pluck('id');
            $sharedContacts = SharedWalletContact::select('shared_wallet_contacts.customer_contact_id',
            'shared_wallet_contacts.limit', 'shared_wallet_contacts.limit_value', 'customers.image',
             'customers.phone', 'customers.name as name')
                ->leftjoin('customer_contacts', 'customer_contacts.id', 'shared_wallet_contacts.customer_contact_id')
                ->leftjoin('customers', 'customers.id', 'customer_contacts.customer_id')
                ->whereIn('shared_wallet_contacts.customer_contact_id', $customerContacts)
                ->get();
            
                foreach ($sharedContacts as $sharedContact) {
                    $sharedContact->type = 'member';
                }

            $groupMembers = GroupMember::select('group_members.customer_contact_id', 'groups.limit',
             'groups.limit_value', 'customers.image', 'customers.phone', 'customers.name')
                ->leftjoin('customer_contacts', 'customer_contacts.id', 'group_members.customer_contact_id')
                ->leftjoin('groups', 'groups.id', 'group_members.group_id')
                ->leftjoin('customers', 'customers.id', 'groups.customer_id')
                ->whereIn('group_members.customer_contact_id', $customerContacts)
                ->get();

            foreach ($groupMembers as $groupMember) {
                $groupMember->type = 'group';
            }

            $result = array_merge($sharedContacts->toArray(), $groupMembers->toArray());
            


            return $this->returnData($result, "تم الحصول على الداتا بنجاح");
        } else {
            return $this->returnError("Unauthoried");
        }
    }
}
