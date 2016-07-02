<?php

/* home.html */
class __TwigTemplate_ee5b6d82be8296e72487e4f6b00c9872aeea85e7c40bed50b04d6c074d9843bc extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"fr\">
<head>
    <meta charset=\"UTF-8\">
    <title>Title</title>
</head>
<body>
    <p>Hello ";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true);
        echo "!</p>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "home.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 8,  19 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html lang="fr">*/
/* <head>*/
/*     <meta charset="UTF-8">*/
/*     <title>Title</title>*/
/* </head>*/
/* <body>*/
/*     <p>Hello {{name}}!</p>*/
/* </body>*/
/* </html>*/
