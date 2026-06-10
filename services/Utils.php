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
     * @param string $string : la chaîne à proté/neger.
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
