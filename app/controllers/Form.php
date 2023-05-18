<?php
    
    class Form extends Controller
    {
        private $buyer;

        public function __construct()
        {
            $this->buyer = $this->model('Buyer');
        }

        public function index()
        {
            if (isset($_POST['daterangepicker']) || isset($_POST['user'])) {
                $data = $this->buyer->search($_POST['daterangepicker'], $_POST['user']);
            } else {
                $data = $this->buyer->index();
            }
            
            $this->view('pages/index', $data);
        }

        public function create()
        {
            $this->view('pages/form');
        }

        public function submit()
        {
            $data = $_POST;
            $data['items'] = json_encode($data['items']);
            $validator = new FormValidator($data);
            $helper = new Helper();

            if ($validator->hasError()) {
                $helper->response(426, $validator->getError());
            } else {
                $data['buyer_ip'] = $_SERVER['REMOTE_ADDR'];
                //$data['items'] = json_encode($data['items']);
                $data['hash_key'] = hash('sha512', $data['receipt_id'] . $helper->rand_str(8));
                $data['entry_at'] = date('Y-m-d');
                if ($this->buyer->store($data)) {

                    setcookie('submit_form', true, time() + (24 * 60 * 60));

                    $helper->response(200, [
                        'type' => 'success'
                    ]);
                }
            }
        }

        public function delete($id)
        {
            $helper = new Helper();
            if ($this->buyer->delete($id)) {
                $helper->response(200, [
                    'type' => 'success'
                ]);
            }
        }        
    }
?>