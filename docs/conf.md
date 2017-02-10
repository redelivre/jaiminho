# Configurações iniciais
Antes de começar a utilizar o Jaiminho, ajuste as configurações iniciais do boletim. 

Você possui duas formas de chegar a configurações:

1) no menu da lateral esquerda:

![](conf/B08927B1-3446-45B5-AFC4-7C6CA3016C19.png)

2) No topo da tela do cinza ao lado do menu da lateral esquerda:

![](conf/0D67E2FE-2661-4751-9537-71E8F14E83FB.png)

Basta clicar en configurações e pronto!

## Configurações de Conta
Agora é hora de informar suas configurações de conta:

![](conf/6774F238-1656-4012-9484-AA7388B81358.png)

Coloque um nome de remetente como “Rede Livre”, Email como “contato@redelivre.org.br”,  um email de retorno de erros “bounce@redelivre.org.br”, a senha do email de retorno “”, o endereço do servidor imap “imap.redelivre.org.br”, e a porta do servidor impa “993”.

## Enviar Email de Teste
Para enviar um email de teste precisados de configurar antes uma conta de envio. Apesar dele ser a caixa ao lado, não sera enviado nada se não temos uma conta de envio configurada.

Se você já possui uma conta configurada basta inserir um email para testar sua configuração de envio no formulário similar a este:

E clicar em Enviar Teste!

![](conf/FFBD4C68-9296-4175-9736-7664AF3AD470.png)

Para ver mais infos você pode clicar no botão vermelho.

## Configuração da Conta de Envio

O Jaiminho oferece 3 tipos de conta de envio de mensagens como podemos ver na figura abaixo, note as abas “Gmail”, “Configuração do Super Admin Rede Livre” e “RedeLivre”:

![](conf/7E037452-F557-4CC6-A04C-D6944A8A846E.png)

Basta selecionar em Método de Entrega qual o método que você vai utilizar para enviar suas mensagens. Abaixo passamos a apresentar cada método de entrega. 📦 

### Configuração do Super Admin Rede Livre ❤️

Este é o método mais simples. Basta ativar ela que você vai utilizar o sistema de envio de emails do servidor da redelivre, que é configurado previamente pelo Super Admin.

### RedeLivre

Este método de envio consta de quatro campos: “Nome de usuário”, “Senha”, “Servidor” e “Porta”.

A critério de exemplo é possível preencher os campos sucessivamente com: contato, , imap.redelivre.org.br, 587


![](conf/467D8F60-CB44-47FE-89D3-124273DF1CE9.png)

### Gmail

Para usar o gmail você precisa habilitar em sua conta escolhida a possibilidade de autenticação de ferramentas menos seguras. Neste link existe uma descrição do funcionamento deste recurso: [Permitir que aplicativos menos seguros acessem sua conta - Ajuda do Conta do Google](https://support.google.com/accounts/answer/6010255?hl=pt-BR) .

Neste outro link você pode ativar a autenticação para ferramentas menos seguras no email do gmail em que você estiver logado em seu navegador: [Configuración de la cuenta: no se admite tu navegador](https://www.google.com/settings/security/lesssecureapps).


![](conf/CFC4F2AA-338C-48BA-B298-A3B57B02C556.png)

O preenchimento dos campos do Gmail são muito simples. Basta escrever seu nome de usuário e senha para a conta escolhida e não esquece de modificar o Método de Envio na caixa dropdown para Gmail.


## Configurações Avançadas de Envio

![](conf/FEAA5ECE-25CE-42BD-9213-2BBE6835CBC0.png)

Nesta configurações é possível gerenciar a quantidade limite de email por dia e por hora de maneira que o gestor controle o seu gasto de créditos. 

Também é possível definir qual o conjunto de caracteres que ira ser utilizado nas mensagens. Isto permite utilizar conjuntos de caracteres que facilitam a escrita em chinês por exemplo.

# Menu das configurações
A area de configurações possui um menu. Nele encontramos o seguinte:

![](conf/D0881616-55E2-435D-B54B-1CDE3862BBFB.png)

**Sending**: Você acabou de ler acima, e se não leu ainda é a primeira parte deste documento, nela você configura sua instalação para envio de mensagens, recebimento de erros no envio, define a quantidade de email enviados por hora, por dia e muito mais.

**Confirmation**:  Você pode configurar as páginas de inscrição e desinscrição, bem como definir qual a página de configuração dos assinantes, definir qual template é o padrão e como é a mensagem de dupla confirmação de inscrição, para que entenda melhor o processo sugerimos ler este texto do mail chimp: [Descripción del proceso de opt-in doble | MailChimp.com: Artículo de Base de Conocimiento](http://kb.mailchimp.com/es/lists/signup-forms/understanding-the-double-opt-in-process)

**Permissões**: Nesta página o usuário tem informações sobre o que pode fazer cada papel no Jaiminho. Aqui é possível configurar seu plugin para estes papeis.

**Notifications**: 

**Formulários**: Nesta página você pode gerenciar seus formulários, estes formulários são de dois tipos  - assinatura inicial (signup) e gerenciamento de assinatura (Manage Subscription)

**Avançado**: Aqui você pode fazer varias correções em seu sistema bem como desfazer algumas configurações voltando elas ao valor original.

**Estilos**: Aqui você pode configurar como é o template padrão do seu sistema. (Ainda não temos certeza mas acreditamos que isso apenas serve para envio de mensagens no modelo antigo, isso pode ser selecionado quando for criar um novo email em Emails >> Criar Email)

## Confirmações
Nesta área você consegue definir a página de inscrição em sua newsletter, definir a página onde seus assinantes podem gerenciar suas inscrições., página de desinscrição e muito mais.
 

As páginas do Jaiminho podem conter ou não o cabeçalho e o rodapé do seu site e você escolhe isso bem aqui:

![](conf/EB5874B6-A6FF-422C-ACE0-4486B325C9A3.png)

Se você escolher Sim (YES) ou Não (NO).

### Gerenciar página onde os assinantes fazem suas inscrições:

Aqui basicamente você pode utilizar a página padrão do sistema ou pode selecionar uma página que você mesmo criou. Para isso troque a opção de Usar página padrão do SendPress (Use default SendPress Page) para Redirecionar para (Redirect to) e na caixa de seleção seleciona a pagina que você criou. Se você não sabe criar páginas veja este artigo https://www.kinghost.com.br/blog/2016/12/como-criar-e-editar-conteudos-wordpress/

![](conf/0678184F-FC29-4EB0-9D6F-1B9859BF1D94.png)

### Gerencia página onde os assinantes confirmam sua inscrição

Esta caixa controla qual a página para confirmação de inscrição os usuários ou são enviados a página que esta no padrão ou podem ser enviados para a página que você selecione em Redirecionar para (redirect to):

![](conf/43317858-EF99-4757-8675-1D362402E4D4.png)

### Gerenciar página de desinsbcrição de assinantes

Nesta caixa você seleciona qual am página onde os assinantes se desinscrevem de suas newsletters. Ou você pode usar o padrão ou definir uma nova página. 

![](conf/7EB469D8-38DB-4601-AC6D-A0736ACB6768.png)

### se você estiver usando formulários personalizados como fica a página?


Basta clicar no botão abaixo e ver como fica isso.

![](conf/47B53489-1B27-4EED-AD56-BC608DAAE652.png)

### Enviar email para que o novo assinante habilite sua conta

Note que isso é um sistema de autenticação dupla. Com isso você garante que quem assinou sua newsletter foi o dono do email e não qualquer pessoa. Isso é importante pois evita que sua lista de assinantes tenham emails inválidos. Sendo assim sugerimos fortemente o uso deste recurso.

![](conf/5D62B573-0FBA-4C3D-8B0B-5A96F723321B.png)

### Configure a a mensagem que é enviado aos usuários

Note que ao optar pelo sistema de autenticação dupla você deve personalizar a mensagem padrão que é enviada aos usuários:

![](conf/75CE8E0D-3188-4F6D-B5A3-A09CEB38C72E.png)

Você pode usar as seguintes tags para inserir informações dinâmicas (link de confirmação, titulo do website, e email que o usuário usou para cadastrar) copie o código e coloque no campo anterior que apresentamos.

![](conf/B2FC7695-F3ED-46F2-BE36-CDE28F9727ED.png)

Por fim selecione o template que vai utilizar:

![](conf/B3881E7B-3E18-4CEB-976A-BEA1FCBA5355.png)

Se não gostou de nenhum destes templates faça um clone de um template em **Emails** > **Modelos** e clique no botão **Editar** do seu novo clone e crie o seu template.

## Permissões

![](conf/BC87AC71-50FE-4B8F-993C-7B3D9ADE95B6.png)

As permissões são uma matriz onde podemos encontrar basicamente os papeis na coluna função e quais as permissões de cada papel:

Criar_Editar_Deletar e ou Enviar Emails
Acesso completo a Relatórios de Envio de Emails
Acesso completo a lista de assinantes
Acesso total as configurações
Acesso completo a Fila de envio de mensagens
Acesso completo aos Extras (note que no presente momento não sabemos o que seriam os extras)

## Notifications

![](conf/97034B96-870F-4677-925D-91074F8B43A2.png)

![](conf/DE598FD1-BBDB-45C5-A246-B8DBCE634A06.png)

## Formulários

Neste página você consegue criar um shortcode que você insere em uma página ou post qualquer, e com isso você passa a ter um formulário personalizado para inscrição em suas newsletters:

![](conf/0DD27955-E6F7-4302-970B-78D188DB1202.png)


### Criando meu primeiro formulário

Para iniciar o processo de criação aperte o botão:

![](conf/3F09EEEE-73C9-4BB3-A2CC-9833A8F09578.png)


Em seguida você passa a ver o seguinte formulário:

![](conf/1EF08561-C669-40C7-BFBA-CAEAA8B73646.png)

Defina o nome do seu novo formulário e o tipo do formulário (Form Type) são dois tipos de formulários (para entrar na newsletter e para o assinante gerenciar as listas que ele esta inscrito). A primeira se chama **Signup** e a segunda **Manage Subscriptions**.

Por exemplo ao iniciar o processo de criação de um formulário do tipo signup você tem as seguintes possibilidades:

![](conf/C5146091-E15D-4A9F-9267-8B482542AB21.png)

E para fazer um formulário do tipo manage subscription, tera os seguintes campos:

![](conf/F59C4E8B-3E8E-4A3A-903C-2CF6BC18CF36.png)

## Avançado:

Aqui você pode reparar suas tabelas de banco de dados relacionada ao Jaiminho apenas apertando este botão. Se você sentir que algo esta estranho com seus templates e configurações 🎲 aperte Opções de Correção de Dados (Data Fix Options)


![](conf/ED411D88-6A11-4820-B6B9-AAB8F1DB8B09.png)

Isso vai abrir uma página com duas opções:

![](conf/52A03F82-D956-4474-A0BB-1FAA7B59A670.png)

Veja que basicamente você pode remover os templates e voltar a ter apenas 2 templates (System Starter e Responsive Starter), abaixo apresentamos os templates que você facilmente pode encontrar em **Emails** >> **Modelos**.  

![](conf/5310DB73-6F79-4F4D-8ADA-867428EA6E2A.png)

E você pode resetar (reiniciar) todas as configurações para o padrão inicial. Ao clicar em Reset Settings. Neste caso são todas as configurações ensinadas nesta sessão. Por isso **CUIDADO**.

### Permita que a equipe do SendPress monitore seu uso do plugin

Ao clicar na checkbox na imagem você permite que a equipe do sendpress tenha informações do seu uso do plugin. Acreditamos que essa seja uma importante contribuição por isso encorajamos nossos usuários a habilitar esse tipo de configuração.

![](conf/34C1E6B4-6CE2-4B74-8745-1F935B6CB441.png)

### Javascript e CSS

Ainda não temos claro quais as alterações desta configuração se tiver clareza envia a sua contribuição. (Baixe o repositório faça a modificação no texto e envie um pull request, se tiver duvida sobre como fazer isso envie uma mensagem para contato@redelivre.org.br)

![](conf/B582F2E2-E489-4238-9406-14776E6FCBA0.png)

### Permitir a inserção de shortcodes no widgets

Se não sabe o que é shortcode e muito menos widget veja aqui:

[Cómo utilizar los shortcodes en WordPress](http://manuelvicedo.com/wordpress/guia-shortcodes/)
[¿Qué son y como usar los Widgets en WordPress?](https://lievanosan.com/que-son-y-como-usar-los-widgets-en-wordpress/)

Uma vez que saiba o que e quer usar shortcodes em widgets basta clicar na checkbox e salvar para habilitar:

![](conf/23A74F96-EA4C-4E47-9D9D-836318D00E41.png)

Note que você vai saber se precisa disso se ao tentar inserir um shortcode aparecer apenas [shortcode] como resultado dessa tentativa.

### Configurando os limites do sistema

Nesta seção você pode configurar os limites do sistema.

![](conf/ADC5042D-0CE1-456B-8052-F49E115B3F72.png)

 Veja que é possível configurar quantos usuários são sincronizados por chamada Ajax (Ainda não temos claro quais as alterações desta configuração se tiver clareza envia a sua contribuição. Baixe o repositório faça a modificação no texto e envie um pull request, se tiver duvida sobre como fazer isso envie uma mensagem para contato@redelivre.org.br).

Note que a rede livre não utiliza o AutoCron por isso não se preocupe com:


![](conf/AB0F4049-4C75-4FC8-95D7-B9A25D07A7C0.png)

Número de mensagens enviadas por execução do cron do Wordpress, sugerimos algo que seja alto:


![](conf/55C57E1E-BE0B-444E-A81A-49BE2D148356.png)

Numero de dias que um email dura no histórico da fila:

![](conf/3ED1C990-762C-4DE4-8B5D-3B87715B45D3.png)

Não temos certeza ainda mas acreditamos que é o numero de emails que são inseridos por vez na fila, no entanto ainda não faz muito sentido:

![](conf/16A9CE60-1157-4C63-A49F-C91DFDABF66F.png)

### Configurações Opcionais


![](conf/FB7CCE09-0AD8-481A-962C-228A3C2ADEEE.png)

#### Use old permalink with ?sendpress=. 

Basicamente o usuário pode usar urls antigas com “?sendpress=”, em caso de ter problemas com as urls (assinante não esta conseguindo ver o email no navegador) se isso acontecer essa opção pode ajudar.

#### Do not track mailto links in email. 

Primeiro se você não sabe o que é um mailto veja o texto: [Uso de mailto en HTML](http://www.webtaller.com/construccion/lenguajes/html/lessons/uso_de_mailto_en_html.php)

Basicamente esses links não vão ser transformados. Aparentemente o sendpress não faz nada com essa informação mas é necessário mais estudo:

(Ainda não temos claro quais as alterações desta configuração se tiver clareza envia a sua contribuição. Baixe o repositório faça a modificação no texto e envie um pull request, se tiver duvida sobre como fazer isso envie uma mensagem para contato@redelivre.org.br).

#### Override email template settings. 

(Ainda não temos claro quais as alterações desta configuração se tiver clareza envia a sua contribuição. Baixe o repositório faça a modificação no texto e envie um pull request, se tiver duvida sobre como fazer isso envie uma mensagem para contato@redelivre.org.br).

#### Show SPNL Logs. 

(Ainda não temos claro quais as alterações desta configuração se tiver clareza envia a sua contribuição. Baixe o repositório faça a modificação no texto e envie um pull request, se tiver duvida sobre como fazer isso envie uma mensagem para contato@redelivre.org.br).

### Informações de Tabelas

Você pode ter informações sobre como estão suas tabelas o sendpress testa se as tabelas estão bem formadas, ou seja se elas não possuem erros que causariam algum tipo de estrago no seu sistema:


![](conf/994EE0F6-442D-418D-BE30-9D5E131EE63E.png)

Para saber se esta tudo bem ou não basta clicar em template check (checagem dos templates) que basicamente são as três tabelas.

Se tudo estiver ok você vai ver:

![](conf/8E01538B-EDAE-4CE2-91E0-F62F6966471D.png)

Caso haja problemas instale as tabelas que estão faltando clicando em Install Missing Tables.

## Estilos
Nesta página não sabemos ao certo o qual o email que esta sendo estilizado, temos uma ideia de que seja o email enviado para assinantes de uma newsletter.

O que pode ser definido neste estilo? Estilos do corpo de texto, podemos ver que o fundo (background), a cor do texto do corpo de texto (Body Text Color) e a cor dos links do corpo de texto (Body Link Color).

![](conf/C33CF35E-E8EA-4062-93A4-A774ED865696.png)

Quando o usuário clica no campo com o valor em hexadecimal (\#E8E8E8) ele é apresentado a uma ferramenta de seleção de cor:

![](conf/1C8DB6F0-BD96-4E25-91DE-03427988C571.png)

Além disso é possível definir o estilo do cabeçalho do email (Header Styles), sendo basicamente a cor de fundo (Background Color) e a cor do Texto do cabeçalho (Text Color).

![](conf/DF954C2C-83B7-4A93-A480-4DBCE1D2FC80.png)

Também é possível definir cores para os conteúdos, cor de fundo (Background), Borda (Border), texto (Text Color) e Link (Link Color).

![](conf/E0FEBCD6-5970-4A38-B75E-2C2100B8748D.png)

Todas essas opções podem ser receptadas ao apertar o botão ao lado de cada entrada de cor (Reset).

Além das cores é possível definir o assunto da mensagem:

![](conf/116176D2-73FD-4B38-BEB6-4775C5427549.png)

E se forem email enviados nos Estados Unidos é necessário preencher este campo:

![](conf/F61A9DE1-BE96-4647-8F23-B98AD4185832.png)

Sua mensagem deve incluir seu endereço postal físico válido. Este pode ser o seu endereço atual, uma caixa de correio que você tenha registrado no Serviço Postal dos Estados Unidos ou uma caixa de correio privada que você tenha registrado em uma agência de correspondência comercial estabelecida de acordo com os regulamentos do Serviço Postal.
