<!-- BEGIN: Footer-->
<footer
    class="{{$configData['mainFooterClass']}} @if($configData['isFooterFixed']=== true){{'footer-fixed'}}@else {{'footer-static'}} @endif @if($configData['isFooterDark']=== true) {{'footer-dark'}} @elseif($configData['isFooterDark']=== false) {{'footer-light'}} @else {{$configData['mainFooterColor']}} @endif">
    <div class="footer-copyright">
        <div class="container">
          <span>&copy; {{ date('Y') }} <a href="https://cristaisdegramado.com.br"
                                          target="_blank">Cristais de Gramado</a>.
          </span>
                <span class="right hide-on-small-only">
            Versão Alpha
          </span>
        </div>
    </div>
</footer>

<!-- END: Footer-->
