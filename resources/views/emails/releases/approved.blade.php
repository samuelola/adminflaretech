@component('mail::message')
# Release Approved 🎵

Hello {{ $release->distributor->name ?? 'Distributor' }},

The release **{{ $release->title }}** has been approved and its metadata files are ready.

---

**Release Details:**
- **Release ID:** {{ $release->id }}
- **Label:** {{ $release->label_name }}
- **Release Date:** {{ $release->release_date }}

---

### 📂 Metadata Files
@component('mail::panel')
- [JSON Metadata]({{ $jsonUrl }})  
- [XML (DDEX) Metadata]({{ $xmlUrl }})  
- [CSV Metadata]({{ $csvUrl }})
@endcomponent

Thank you for working with us!  
**{{ config('app.name') }} Team**
@endcomponent
