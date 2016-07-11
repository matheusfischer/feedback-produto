Sistema

Quesitos implementados:
	R01. O sistema dever� gerenciar os usu�rios, permitindo-os se cadastrar e editar seu cadastro;
	R02. O sistema poder� ser logado atrav�s do e-mail e senha do usu�rio;
	R03. O sistema dever� mostrar coment�rios a todos que o acessarem, por�m dever� permitir inserir coment�rios apenas a usu�rios logados;
	R04. O sistema dever� exibir qual � o autor do coment�rio e dia e hor�rio da postagem;
	R05. O sistema n�o dever� possuir n�mero m�nimo de coment�rio por usu�rio;
	
	RD1. O sistema dever� permitir o usu�rio editar os pr�prios coment�rios (exibindo a data de cria��o do coment�rio e data da �ltima edi��o);
	RD2. O sistema dever� possuir hist�rico de edi��es do coment�rio;
	RD3. O sistema dever� permitir o usu�rio excluir os pr�prios coment�rios;
	RD4. O sistema dever� possuir um usu�rio administrador que pode excluir todos os coment�rios;
	RD5. O sistema dever� criptografar a senha do usu�rio;
	RD6. O sistema dever� permitir o usu�rio fazer o upload de uma foto de perfil e exibi-la nos coment�rios desse usu�rio.

Configuracao

	A configura��o dever� ser feita da maneira padr�o do CakePHP, pelo arquivo database.php (cake/app/Config/database.php).

Acesso
	
	No dump.sql ja existe um usuario administrador criado (admin@admin.com:admin). O acesso funcionar� somente se as chaves de criptografia do
	CakePHP n�o forem alteradas.