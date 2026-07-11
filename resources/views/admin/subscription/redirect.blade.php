<!DOCTYPE html>
<html>
<body>
<p>Redirecting to eSewa...</p>
<form id="esewaForm" method="POST" action="{{ $paymentUrl }}">
    @foreach($payload as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
</form>
<script>document.getElementById('esewaForm').submit();</script>
</body>
</html>