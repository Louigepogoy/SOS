@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Success', text: @json(session('success')), timer: 2500, showConfirmButton: false });</script>
@endif
@if(session('error'))
<script>Swal.fire({ icon: 'error', title: 'Error', text: @json(session('error')) });</script>
@endif
