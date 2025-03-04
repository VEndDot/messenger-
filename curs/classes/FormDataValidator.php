<?php 
    /**
     * Проверяет, есть ли ошибки при заполнении 
     * формы регистрации
     * 
     *
     */
class FormDataValidator {

    /**
     * В случае неправильной формы, вызывает
     * исключение
     * @param array $formData Данные отправленной формы
     * @return Exception
     */
    public function checkFormData($formData){
        if(empty($formData['first_name']) || is_numeric($formData['first_name'])){
            throw new Exception("Имя не может быть пустым и не должно быть числом");
        }
        if(empty($formData['last_name']) || is_numeric($formData['last_name'])){
            throw new Exception("Фамилия не может быть пустой и не должно быть числом");
        }
        if(!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)){
            throw new Exception("Некорректный адрес почты");
        }
        if($formData['age'] < 18 || $formData['age']>70){
            throw new Exception("Возраст должен быть от 18 до 70 лет");
        }
        if($formData['password'] !== $formData['password2']){
            throw new Exception("Пароли должны совпадать");
        }
        if(strlen( $formData['password']) < 8){
            throw new Exception("Пароль должен быть не менее 8 символов");
        }
    }

}
?>