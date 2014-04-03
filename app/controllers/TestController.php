    <?php

    // DB::tables
    // table : customers { FIELDS:  'id : int', 'name:'varchar' }
    // table : phone_numbers { FIELDS: 'id:int, customer_id:int [FK] ', 'active:boolean' }

    // Customer table will have one to many relationship to Phone_Numbers Table

    // API Challenge 1
    //1- get all phone numbers
    // GET www.example.com/phone

    class Phone {
        protected $customer;
        protected $phone;
        function __construct(PhoneRepo $phone, CustomerRepo $cust) {
            $this->phone = $phone;
            $this->cust = $cust;
        }

        public function index() {
            // get all phone numbers
            $phoneNumbers = $this->phone->all();
            return Response::json(array(
                'success' => true,
                'message'=> '',
                'data' => $phoneNumbers,
            ), 200);
        }
    }

    // API Challenge 2
    // Get Phone Number Filtered By Customers.. i.e Get Customer's Phone no
    // GET www.example.org/customerId/phone
    class Customer {
        protected $customer;
        protected $phone;

        function __construct(PhoneRepo $phone, CustomerRepo $customer) {
            $this->phone = $phone;
            $this->customer = $customer;
        }

        public function getPhone($id) {
            $customer = $this->customer->findById($id);
            // Phone can be a function to get the customer phone number in Customer Repo
            if($customer) {
                $phone = $customer->phone()->get();
                return Response::json(array(
                    'success' => true,
                    'message'=> '',
                    'data' => $phone,
                ), 200);
            } else {

                return Response::json(array(
                    'success' => false,
                    'message'=> 'False Customer Id'
                ), 400);

            }

        }
    }

    // API Challenge 3
    // activate a phone number
    // POST => PATCH www.example.org/phone/1/edit

    class Phone {

        protected $customer;
        protected $phone;
        function __construct(PhoneRepo $phone, CustomerRepo $customer) {
            $this->phone = $phone;
            $this->customer = $customer;
        }

        /**
         * @param $id
         * @return boolean
         */
        public function update($id) {

            // either send ID
            // get all phone numbers
            $phone = $this->phone->findById($id);
            $phone->active = 1;
            if($phone->save()) {
                return Response::json(array(
                    'success' => true,
                    'message'=> 'Phone Activated'
                ), 200);
            }
            return Response::json(array(
                'success' => false,
                'message'=> 'Couldnt Update, Sorry'
            ), 400);
        }

    }

    ?>