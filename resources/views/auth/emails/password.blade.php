<center>
    <h3>
尊敬的用户：<br>
    您收到了此邮件的原因是我们收到了您要重置密码的请求。<br>
    You are receiving this email because we received a password reset request for your account<br><br>

        <button href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}" style="width: 100px;"> 重置密码</button><br><br>

    如果这不是您本人的操作，您可以不必采取进一步操作。<br>
    If you did not request a password reset, no further action is required.<br><br>
    </h3>
    <h5>点击此链接找回你的密码：<a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a><br></h5>
</center>