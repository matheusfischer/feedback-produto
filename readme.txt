Sistema

Quesitos implementados:
	R01. O sistema deverá gerenciar os usuários, permitindo-os se cadastrar e editar seu cadastro;
	R02. O sistema poderá ser logado através do e-mail e senha do usuário;
	R03. O sistema deverá mostrar comentários a todos que o acessarem, porém deverá permitir inserir comentários apenas a usuários logados;
	R04. O sistema deverá exibir qual é o autor do comentário e dia e horário da postagem;
	R05. O sistema não deverá possuir número mínimo de comentário por usuário;
	
	RD1. O sistema deverá permitir o usuário editar os próprios comentários (exibindo a data de criação do comentário e data da última edição);
	RD2. O sistema deverá possuir histórico de edições do comentário;
	RD3. O sistema deverá permitir o usuário excluir os próprios comentários;
	RD4. O sistema deverá possuir um usuário administrador que pode excluir todos os comentários;
	RD5. O sistema deverá criptografar a senha do usuário;
	RD6. O sistema deverá permitir o usuário fazer o upload de uma foto de perfil e exibi-la nos comentários desse usuário.

Configuracao

	A configuração deverá ser feita da maneira padrão do CakePHP, pelo arquivo database.php (cake/app/Config/database.php).

Acesso
	
	No dump.sql ja existe um usuario administrador criado (admin@admin.com:admin). O acesso funcionará somente se as chaves de criptografia do
	CakePHP não forem alteradas.