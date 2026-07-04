<?php

class Utils
{
    /**
     * Récupère une variable de $_REQUEST.
     * @param string $variableName : le nom de la variable.
     * @param mixed $defaultValue : la valeur par défaut si absente.
     * @return mixed : la valeur de la variable ou la valeur par défaut.
     */
    public static function request(string $variableName, mixed $defaultValue = null): mixed
    {
        return $_REQUEST[$variableName] ?? $defaultValue;
    }

    /**
     * Retourne le token CSRF de la session ou en génère un nouveau.
     * @return string : le token CSRF courant.
     */
    public static function csrfToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * Génère le champ caché CSRF à placer dans les formulaires POST.
     * @return string : le champ HTML contenant le token CSRF.
     */
    public static function csrfInput(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . self::safe(self::csrfToken()) . '">';
    }

    /**
     * Vérifie que le token CSRF reçu correspond à celui de la session.
     * @param mixed $token : le token reçu depuis le formulaire.
     * @return bool : true si le token est valide.
     */
    public static function isValidCsrfToken(mixed $token): bool
    {
        if (!isset($_SESSION['csrf_token']) || !is_string($token)) {
            return false;
        }

        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Indique si une URL d'image est vide ou utilisable par l'application.
     * @param string $url : l'URL à contrôler.
     * @return bool : true si l'URL est vide ou valide en http/https.
     */
    public static function isValidImageUrl(string $url): bool
    {
        if ($url === '') {
            return true;
        }

        if (strlen($url) > 255 || !filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        return in_array($scheme, ['http', 'https'], true);
    }

    /**
     * Redirige vers une action.
     * @param string $action : l'action (correspond aux routes dans index.php).
     * @param array $params : paramètres supplémentaires ['cle' => 'valeur'].
     * @return void
     */
    public static function redirect(string $action, array $params = []): void
    {
        $url = "index.php?action=$action";
        foreach ($params as $paramName => $paramValue) {
            $url .= "&$paramName=$paramValue";
        }
        header("Location: $url");
        exit();
    }

    /**
     * Raccourci pour htmlspecialchars (usage dans les vues).
     * @param string $string : la chaîne à protéger.
     * @return string : la chaîne protégée.
     */
    public static function safe(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Convertit une date en français (ex: "samedi 15 juillet 2023").
     * Nécessite l'extension PHP intl.
     * @param DateTime $date : la date à convertir.
     * @return string : la date formatée en français.
     */
    public static function convertDateToFrenchFormat(DateTime $date): string
    {
        $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $dateFormatter->setPattern('EEEE d MMMM Y');
        return $dateFormatter->format($date);
    }

}
