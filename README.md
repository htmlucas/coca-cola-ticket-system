# 📄 Descrição do projeto

Campaign Ticket Platform é uma aplicação fullstack desenvolvida em Laravel e Vue.js para gerenciamento de campanhas promocionais baseadas em registro e validação de tickets.

O sistema permite que usuários se cadastrem utilizando CPF como identificador principal e registrem tickets associados a uma campanha ativa, enviando comprovantes em imagem para validação administrativa.

A plataforma foi projetada com foco em escalabilidade, separação de responsabilidades e boas práticas de arquitetura, simulando um cenário real de campanhas promocionais utilizadas por empresas.

# 🚀 Funcionalidades principais
 ## 👤 Área do usuário
- Cadastro e autenticação com CPF
- Associação do usuário a cidade e estado
- Registro de tickets com número de série único
- Upload de comprovante (imagem)
- Visualização do histórico de tickets
- Acompanhamento do status dos tickets (pendente, aprovado, rejeitado)
- Visualização de campanha ativa e regras
 ## 🛠 Área administrativa
- Dashboard administrativo
- Gerenciamento de usuários
- Gerenciamento de cidades e estados
- Visualização de todos os tickets cadastrados
- Visualização e validação de comprovantes enviados
- Aprovação ou rejeição de tickets
- Edição e exclusão de registros
- Configuração de campanhas (datas de início e fim)
## 🧠 Regras de negócio
 - CPF é o identificador único de cada usuário
- Número de série dos tickets deve ser único no sistema
- Tickets só podem ser registrados dentro do período ativo da campanha
- Cada ticket deve estar vinculado a um usuário e uma cidade
- Imagens de comprovante são armazenadas via storage seguro
## 🏗️ Arquitetura e tecnologias
- Laravel (Backend)
- Vue 3 + Composition API (Frontend)
- Vite
- TailwindCSS
- PostgreSQL
- API RESTful
- Estrutura modular com separação entre área pública e administrativa
## 🎯 Objetivo do projeto
Este projeto foi desenvolvido com fins educacionais para simular um sistema real de campanha promocional, abordando conceitos de:

- Autenticação e autorização
- Modelagem relacional de dados
- Upload de arquivos
- Regras de negócio complexas
- Painel administrativo
- Arquitetura escalável fullstack
