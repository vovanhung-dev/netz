// resources/views/emails/contact_submitted.blade.php
@component('mail::message')
# New Contact Message

**Name:** {{ $m->name }}

**Phone:** {{ $m->phone }}

**Email:** {{ $m->email ?? '—' }}

**Content:**
> {{ $m->content ?? '—' }}

_Submitted at {{ $m->created_at->toDayDateTimeString() }}_
@endcomponent
