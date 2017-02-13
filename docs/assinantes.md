# assinantes
Neste página você consegue ver todas as listas e os assinantes inscritos no seu Jaiminho:

### Listas

Nesta tabela você pode ver qua temos 4 colunas, sendo que a primeira mostra o nome da lista de assinantes, mostra o numero de pessoas ativas, quando foi a data o ultimo envio (quando essa lista foi utilizada pela ultima vez), e por ultimo temos as ações que podemos ser realizadas sobre essa lista.


![](assinantes/37066EBE-1410-443F-A8DE-56B9FC1CE314.png)

As ações que podem ser realizadas sobre essa lista são:

**Ver**: permite ver uma lista dos assinantes;
**Importar**: permite importar novos assinantes por meio de um arquivo cdv (planilha a moda antiga); 
**Adicionar**: permite adicionar um assinante por meio de um formulário, ou por meio de um textarea (Campo Grande que permite colocar um email a cada linha e que adiciona vários assinantes por vez);
**Exportar**: permite exportar sua lista de assinantes;
**Formulario** : permite obter o html de um formulário que por sua vez uma vez que preenchido por qualquer pessoa permite que ele passe a fazer parte desta lista.

### Ver

Nesta tela podemos ver todas os assinantes que temos nesta lista. Note que temos 5 colunas, O email do assinante, o seu primeiro nome, o ultimo nome, seu status nesta lista, e a data em que entrou nesta lista.

![](assinantes/B96E4A6B-2D36-45D7-891B-BF17FB79FADE.png)

Existe também o perigo botão remover todos os usuários desta lista, identificado em vermelho:

![](assinantes/F97186E0-DB6E-4B7A-A6DB-D0A2FF335D6C.png)

Você também pode selecionar cada um dos assinantes que quer remover e realizar uma ação em massa de remoção de assinantes:

![](assinantes/DE64F521-E49F-4A39-8900-4CC0B1804759.png)

Pode filtrar seus assinantes de vários modos, qualquer status/ Any Status (aparecem todos), Não Confirmado_Unconfirmed (pessoas que se inscreveram mas não acessaram o link de confirmação que foi enviado para o email dela), Ativo_Active  pessoas que estão ativas no sistema, Desinscritos/Unsubcribed pessoas que deixaram a lista, Bounced pessoas que ao enviar mensagens por algum motivo as mensagens retornaram. 


![](assinantes/95EC8B6F-B6E3-4CB0-B7AD-88221533B3C8.png)

### Importar

Aqui você pode importar CSV  com lista de usuário,  note abaixo tenho um CSV muito simples que possui apenas uma coluna (email) com 3 emails.


![](assinantes/AAF8C62F-068A-413C-9D3C-40556CEDAE73.png)

Essa lista poderia ser com 1k emails, sem problemas o sistema permite a você importar do mesmo jeito que vamos mostrar para você. Vamos lá. Vá ate a tela inicial dos assinantes e escolha a lista onde você quer importar seus novos assinantes. Note que você pode fazer isso para várias listas.

![](assinantes/C0C1FBED-7DE5-4CED-8A8F-E2B59A7FC432.png)

Após encontrar a lista que você quer importar seus novos assinantes clique em:

![](assinantes/C8B9D6DE-C7A6-42D9-85B4-49E67ED0EE58.png)


Muito bem agora você vai ver uma tela como esta:

![](assinantes/7C9DF91A-F4F0-4CFC-8D73-0EBFFA202835.png)

Clique em examinar e passe e selecione o arquivo que você quer importar:

![](assinantes/D20DEEAB-FFC7-4316-8C0F-1E7A02837FDB.png)

No meu caso eu tenho o arquivo emails.csv que apresentamos acima. Selecione ele. Você vai ficar com seu campo de anexo de arquivo assim:

![](assinantes/79F49E74-2E08-4F2A-B3B8-F2EDD8138C00.png)


Aperte o botão upload e você vai ser redirecionado para uma página similar a esta:

![](assinantes/C5687ECC-583F-40FD-B9A9-07DAB3422132.png)

Basta dizer do que se trata a coluna com emails, se você tiver mais colunas informe ao sistema se elas se enquadram com algum dos filtros:


![](assinantes/8256B4AF-837D-429E-9522-A524711DF481.png)

As que não se enquadram com nenhum deste filtros marque apenas No Match. Por fim clique em:


![](assinantes/ABC8E8C4-6E5D-4449-B647-24C79D244CAE.png)

E você vai ter seu emails importados para sua lista:

![](assinantes/EEBF7865-3FB5-4BA4-8D5E-39CBE5BCB5A4.png)

### Adicionar um ou mais usuários por meio de formulário ou textarea

Veja como é simples adicionar um usuário por meio de um formulário, na página principal de assinantes selecione a lista que você objetiva importar um novo assinante e clique no botão Adicionar:

![](assinantes/37066EBE-1410-443F-A8DE-56B9FC1CE314%201.png)

Você deve ser redirecionado para esta tela:

![](assinantes/A5E5C7BF-08E4-4B20-B99F-BEACAFA15D8B.png)

Preencha o formulário com as informações que você possui do seu novo assinante e clique em enviar.

Para adicionar um conjunto de assinantes você pode inserir neste campo um assinante por linha, algo similar a isso:

![](assinantes/B4DF84BA-A229-4464-BB23-5507E7666E88.png)

Note que estou tratando do mesmo email apenas para critério de exemplo. Você claramente vai inserir um usuário diferente por linha.

### Como exportar suas listas de assinantes

Vá ate a páginas principal de assinantes e seleciona a lista que objetiva exportar:

![](assinantes/37066EBE-1410-443F-A8DE-56B9FC1CE314%202.png)

Agora basta clicar uno botão Exportar e pronto. Vai aparecer uma caixa como esta para você selecionar onde quer salvar o seu download:

![](assinantes/85644F9F-C3A6-4147-971C-FEFABFCA56DD.png)

Salve onde quiser e depois abra a lista e veja seus assinantes e as infos que possui deles:

![](assinantes/6C579B94-4729-441E-8186-3B19DB781099.png)

As colunas correspondem a primeira linha enquanto as linhas começam a partir da segunda linha. Veja que os dados estão separados por virgulas. Se não há conteúdo entre virgulas é `porque a coluna não esta preenchida para aquele assinante.

### Obter um formulário para aquela lista

Essa é uma tarefa simples que o Jaiminho fornece. Você apenas deve entrar  na página principal assinantes e selecionar a lista que você quer obter um formulário e clicar em Formulário:

![](assinantes/37066EBE-1410-443F-A8DE-56B9FC1CE314%203.png)

Você sera enviado para a seguinte tela:

![](assinantes/D821EA3E-CE22-457F-94D6-4F42E12C4C42.png)

Selecione qual o tipo de página que vai ser usado em seu formulário, você pode selecionar a página padrão ou pode criar sua própria página. Bem como obter resultados em JSON ou redirecionar a uma url especifica. Por fim basta copiar o html (formulário) gerado e colar no seu código html.

### Ver todos os assinantes em suas listas

Para ver isso é muito simples, vá a ate a página principal de assinantes e veja que existe um menu:

![](assinantes/AA1FC748-8D53-4DE0-A3B3-6A294415CA95.png)

Clique em All Subscribers. E você vai ser redirecionado para a seguinte tela:

![](assinantes/3C04EE9D-CE4E-482F-A0E1-F7FBEDADA8ED.png)

Aqui você pode basicamente incluir um novo assinante. Editar assinantes individualmente. Remover todos os assinantes e exportar todos os assinantes. Existe uma ação em massa que permite remover assinantes específicos que você selecionar por meio da checkbox em cada linha.
