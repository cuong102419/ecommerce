<x-mail::message>
# Xác thực tài khoản

Xin chào **{{ $user->name }}**,

Cảm ơn bạn đã đăng ký tài khoản tại **{{ config('app.name') }}**.

Vui lòng nhấn vào nút bên dưới để xác thực tài khoản của bạn.

<x-mail::button :url="$verifyUrl">
Xác thực tài khoản
</x-mail::button>

Link xác thực sẽ hết hạn sau **24 giờ**.

Nếu bạn không thực hiện đăng ký tài khoản, vui lòng bỏ qua email này.

Trân trọng,<br>
{{ config('app.name') }}
</x-mail::message>