<?php 
    if (Auth::check()) {
        ?>
<footer class="app-footer">
    <div>
        <a href="https://www.cronograma.pt">
            Cronograma
        </a>
        <span>
            © 2018 Cronograma.
        </span>
    </div>
    <div class="ml-auto">
        <span>
            Powered by
        </span>
        <a href="http://www.cronograma.pt">
            Cronograma (Laravel + CoreUI)
        </a>
    </div>
</footer>
<?php } ?>