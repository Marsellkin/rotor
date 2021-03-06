@if (setting('recaptcha_public') && setting('recaptcha_private'))
    <script src="//www.google.com/recaptcha/api.js"></script>
    <div class="g-recaptcha" data-sitekey="{{ setting('recaptcha_public') }}"></div>
    {!! textError('protect') !!}
@else
    <div class="form-group{{ hasError('protect') }}">
        <label for="protect">{{ trans('common.verification_code') }}:</label>
        <img src="/captcha" onclick="this.src='/captcha?'+Math.random()" class="rounded" alt="" style="cursor: pointer;">
        <input class="form-control" name="protect" id="protect" maxlength="6" required>
        {!! textError('protect') !!}
    </div>
@endif
