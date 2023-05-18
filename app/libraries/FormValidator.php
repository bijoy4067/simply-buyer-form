<?php
class FormValidator {
    private $data;
    private $errors = [];
    
    public function __construct($post_data) {
        $this->data = $post_data;
        $this->validateForm();
    }
    
    public function validateForm() {
        
        $this->validateAmount();
        $this->validateBuyer();
        $this->validateReceiptId();
        $this->validateItems();
        $this->validateBuyerEmail();
        $this->validateCity();
        $this->validatePhone();
        $this->validateNote();
        $this->validateEntryBy();
    }
    
    private function validateAmount() {
        if (!isset($this->data['amount']) || !is_numeric($this->data['amount']) || strlen($this->data['buyer']) > 10) {
            $this->addError('amount', 'Please enter a valid amount.');
        }
    }
    
    private function validateBuyer() {
        if (!isset($this->data['buyer']) || !preg_match("/^[a-zA-Z0-9 ]*$/", $this->data['buyer']) || strlen($this->data['buyer']) > 20 || empty($this->data['buyer'])) {
            $this->addError('buyer', 'Please enter a valid buyer name.');
        }
    }
    
    private function validateReceiptId() {
        if (!isset($this->data['receipt_id']) || !preg_match("/^[a-zA-Z0-9 ]*$/", $this->data['receipt_id']) || strlen($this->data['receipt_id']) > 20 || empty($this->data['receipt_id'])) {
            $this->addError('receipt_id', 'Please enter a valid receipt id.');
        }
    }
    
    private function validateItems() {
        if (!isset($this->data['items']) || strlen($this->data['items']) > 255 || empty($this->data['items'])) {
            $this->addError('items', 'Please enter a valid item.');
        }
    }
    
    private function validateBuyerEmail() {
        if (!isset($this->data['buyer_email']) || !filter_var($this->data['buyer_email'], FILTER_VALIDATE_EMAIL) || strlen($this->data['buyer_email']) > 50) {
            $this->addError('buyer_email', 'Please enter a valid email.');
        }
    }
    
    private function validateNote() {
        if (!isset($this->data['note']) || str_word_count($this->data['note']) > 30 || empty($this->data['note'])) {
            $this->addError('note', 'Please enter a valid note.');
        }
    }
    private function validateCity() {
        if (!isset($this->data['city']) || !preg_match("/^[a-zA-Z ]*$/", $this->data['city']) || strlen($this->data['city']) > 20 || empty($this->data['city'])) {
            $this->addError('city', 'Please enter a valid city.');
        }
    }
    
    private function validatePhone() {
        if (!isset($this->data['phone']) || !preg_match("/^[0-9]*$/", $this->data['phone']) || strlen($this->data['phone']) > 20 || empty($this->data['phone'])) {
            $this->addError('phone', 'Please enter a valid phone number.');
        }
    }
    
    
    private function validateEntryBy() {
        if (!isset($this->data['entry_by']) || !is_numeric($this->data['entry_by']) || strlen($this->data['entry_by']) > 10) {
            $this->addError('entry_by', 'Please enter a valid entry by.');
        }
    }
    
    private function addError($key, $message) {
        $this->errors[$key] = $message;
    }

    public function hasError()
    {
        if (count($this->errors) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getError()
    {
        return $this->errors;
    }
}
?>