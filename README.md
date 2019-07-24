# Backend-API-vendala
Para iniciar basta seguir esses passos
1 - composer install<br/>
2 - configuração do .env<br/>
3 - php artisan key:generate<br/>
4 - php artisan vendor:publish<br/>
5 - php artisan passport:install<br/>
<br/>
Basta inciar o servidor
php artisan serve
<br/>
<br/>
Foco foi na criação de produtos, você pode cadastrar um kit, mas o nome não pode ser alterado, tanto na criação quanto na edição, caso deseja alterar algum produto do kit, terá que criar um novo.
<br/>
O kit é um tipo JSON, onde terá os id dos produtos pertencentes ao kit(Isso é para verificar se é um kit e para histórico)
Foi utilizado para autenticação o oauth2.0
