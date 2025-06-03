@component('mail::message')
# 📩 Novo Contato Recebido

Você recebeu um novo contato através do site em **{{ $datetime }}**.

## 👤 Dados do Contato

**Nome:** {{ $contact->name }}  
**Email:** {{ $contact->email }}  
**Telefone:** {{ $contact->phone ?? 'Não informado' }}  
**Empresa:** {{ $contact->company ?? 'Não informada' }}  
**Assunto:** {{ $contact->subject }}

## 💬 Mensagem

{{ $contact->message }}

@component('mail::button', ['url' => $admin_url, 'color' => 'primary'])
📊 Ver no Painel Admin
@endcomponent

@component('mail::panel')
**💡 Dica:** Você pode responder diretamente a este email. O endereço de resposta foi configurado automaticamente para {{ $contact->email }}.
@endcomponent

---

**Nice Designs** - Sistema de Gerenciamento  
Este email foi enviado automaticamente quando um novo contato foi recebido.

@endcomponent
