<?php

namespace App\Http\Controllers\api;

use App\CustomerContact;
use App\GroupMember;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\AddCustomerContact;
use Illuminate\Http\Request;
use App\traits\ResonseTrait;
use App\Helpers\GeneralHelper;
use App\Helpers\WalletHistoryGeneralHelper;
use App\Http\Requests\Contact\deleteCustomerContactsRequest;
use App\Models\Customer;
use App\Models\Wallet;
use App\SharedWalletContact;

class CustomerContactController extends Controller
{
    use ResonseTrait;
    public function AddCustomerContact(AddCustomerContact $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            if ($customer->phone == $request->phone) {
                return $this->returnError("لا يممكن اضافه رقمك !!");
            }
            $contact = Customer::where('phone', $request->phone)->first();

            $ifFound = CustomerContact::where('customer_id', $customer->id)->where('phone', $request->phone)->first();
            if ($contact && !$ifFound) {
                $CustomerContact =
                    CustomerContact::create([
                        'customer_id' => $customer->id,
                        'contact_id' => $contact->id,
                        'phone' => $request->phone,
                        'full_name' => $request->full_name,
                    ]);
                return $this->returnData($CustomerContact, "تم الاضافه بنجاح");
            } else {
                return $this->returnError(" يجب ان يكون مستخدم فى أبشر من قبل !! او تم اضافته من قبل");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function getCustomerContacts(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $contacts = CustomerContact::select('customer_contacts.id', 'customer_contacts.contact_id', 'customer_contacts.phone', 'customer_contacts.full_name', 'customers.image')
                ->leftjoin('customers', 'customers.id', 'customer_contacts.contact_id')
                ->where('customer_id', $customer->id)->get();
            return $this->returnData($contacts, "تم الحصول على الداتا بنجاح");
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function deleteCustomerContacts(deleteCustomerContactsRequest $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $contact = CustomerContact::where('id', $request->customer_contact_id)->first();
            $groupMembers = GroupMember::where('customer_contact_id', $request->customer_contact_id)->get();
            $sharedWalletContacts = SharedWalletContact::where('customer_contact_id', $request->customer_contact_id)->get();
            if ($contact) {
                $contact->delete();
                if ($groupMembers) {
                    foreach ($groupMembers as $member) {
                        $member->delete();
                    }
                }
                if ($sharedWalletContacts) {
                    foreach ($sharedWalletContacts as $sharedWalletContact) {
                        $sharedWalletContact->delete();
                    }
                }
                return $this->returnData([], "تم المسح بنجاح");
            } else {
                return $this->returnError("This id not found");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function sendAmountToAnotherContact(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $contact = CustomerContact::select('contact_id')->where('id', $request->customer_contact_id)->where('customer_id',$customer->id)->first();
            if ($contact) {
                $customer_wallet = Wallet::where('customer_id', $customer->id)->first();
                if($customer_wallet->wallet_balance <= 0 || $customer_wallet->wallet_balance < $request->amount )
                {
                    return $this->returnError("رصيد محفظتك لا يكفى لارسال المبلغ");

                }else{

                    $contact_wallet = Wallet::where('customer_id', $contact->contact_id)->first();
                    $amount = $request->amount;
    
                    //Remove amount from customer wallet and history
                    $customer_wallet->wallet_balance -= $amount;
                    $customer_wallet->save();
                    WalletHistoryGeneralHelper::addCustomerWalletHistory($amount, 'Customer', 'Minus', $customer->id, $customer_wallet->id, null);
    
                    //Add amount to contact Wallet and history
                    $contact_wallet->wallet_balance += $amount;
                    $contact_wallet->save();
                    WalletHistoryGeneralHelper::addCustomerWalletHistory($amount, 'Customer', 'Add', $contact->contact_id, $contact_wallet->id, null);
    
                    return $this->returnData([],'The amount has been sent successfully');
                }
            } else {
                return $this->returnError("This contact not found");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }
}
