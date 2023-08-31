<?php if (\zFramework\Core\Facades\Auth::check()) : ?>
<button class="btn btn-sm btn-outline-light border"
    onclick="$.system.signout(this);">{{ _l('lang.signout') }}</button>
<?php else : ?>
<button class="btn btn-sm btn-outline-light border"
    data-modal="{{ route('auth-form') }}">{{ _l('lang.signin') }}</button>
<?php endif ?>