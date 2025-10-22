<?php
require_once __DIR__ . '/../../src/Config/autoloader.php';

namespace includes;

class Footer
{
    public static function content(): string
    {
        return `
</main>

<footer>
    <p>&copy; <?= date('Y') ?> SPEEP - Tous droits réservés</p>
</footer>

</body>

</html>`;
    }
}
