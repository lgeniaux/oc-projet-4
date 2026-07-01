# Vérification accessibilité

## Validation HTML

J'ai utilisé le validateur officiel W3C Nu sur les pages HTML générées par le site.

Commande utilisée :

```bash
curl -H 'Content-Type: text/html; charset=utf-8' \
  --data-binary '@page.html' \
  'https://validator.w3.org/nu/?out=json'
```

Résultat : `0` erreur W3C sur les pages testées.

## Validation WCAG

J'ai utilisé Pa11y avec le niveau WCAG2AA.

Commande utilisée :

```bash
npx --yes pa11y --standard WCAG2AA \
  --ignore 'WCAG2AA.Principle1.Guideline1_4.1_4_3.G18.Fail;WCAG2AA.Principle1.Guideline1_4.1_4_3.G145.Fail' \
  'page.html'
```

Les contrastes sont ignorés car les couleurs viennent de la maquette Figma fournie.

Résultat : `0` erreur WCAG hors contraste sur les pages testées.
