<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
        version="1.0"
        xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
        xmlns:exsl="http://exslt.org/common"
        >
    <xsl:decimal-format grouping-separator=" " decimal-separator="," name="rur"/>
    <xsl:variable name="readMoreLimit" select="99999"/>

    <xsl:template match="/data/page">
        <xsl:apply-templates select="entry"/>
    </xsl:template>

    <xsl:template match="/data/page/entry">
        <xsl:apply-templates select="bloki/item"/>
    </xsl:template>

    <xsl:template match="/data/page/entry/bloki/item">

    </xsl:template>

    <xsl:template match="/data/page/entry/bloki/item[blok/item]">
        <xsl:apply-templates select="/data/page-blocks/entry[@id = current()/@id]"/>
    </xsl:template>

    <!-- Page blocks -->

    <xsl:template match="/data/page-blocks/entry">
        <xsl:apply-templates select="blok/item"/>
    </xsl:template>

    <xsl:template match="/data/page-blocks/entry/yakor">
        <a name="{.}"/>
    </xsl:template>

    <xsl:template match="/data/page-blocks/entry/tip">
    </xsl:template>

    <xsl:template match="/data/page-blocks/entry[tip/item/@handle = 'section']">
        <xsl:choose>
            <xsl:when test="$link = 'catalog'">

            </xsl:when>
            <xsl:when test="$link = 'services'">
                <section class="block-wrapper {blok/item/@section-handle}-wrapper container">
                    <xsl:apply-templates select="/data/block-article/entry" />
                </section>
            </xsl:when>
            <xsl:when test="$link = 'make-an-order'">
                <section class="block-wrapper {blok/item/@section-handle}-wrapper container">
                    <xsl:apply-templates select="/data/block-place-an-order/entry" />
                </section>
            </xsl:when>
            <xsl:when test="$link = 'success'">
                <section class="block-wrapper {blok/item/@section-handle}-wrapper container">
                    <div class="container">
                        <xsl:apply-templates select="/data/block-success-message/entry" />
                    </div>
                </section>
            </xsl:when>
            <xsl:when test="$link='' and $category='' and $product=''">
                <div class="container main-content">
                    <section class="block-wrapper {blok/item/@section-handle}-wrapper span7">
                        <xsl:apply-templates select="/data/block-tovar-na-glavnoy" />
                    </section>
                    <aside class="block-wrapper blok-form-wrapper span3">
                        <xsl:apply-templates select="/data/block-form" />
                    </aside>
                </div>
            </xsl:when>

            <!-- Страница контактов -->
            <xsl:when test="$link='contacts' and $category='' and $product=''">
                <section class="block-wrapper {blok/item/@section-handle}-wrapper container" >
                    <div class="wrapper">
                        <xsl:apply-templates select="/data/block-contacts/entry" />
                    </div>
                </section>
            </xsl:when>

            <!-- Страница новостей -->
            <xsl:when test="$link='news'">
                <section class="block-wrapper {blok/item/@section-handle}-wrapper" >
                    <xsl:apply-templates select="/data/block-news/entry" />
                </section>
            </xsl:when>
            <xsl:otherwise>
                <section class="block-wrapper {blok/item/@section-handle}-wrapper">
                    <xsl:apply-templates select="yakor"/>
                    <xsl:apply-templates select="blok/item"/>
                </section>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="/data/page-blocks/entry[tip/item/@handle = 'article']">
        <article class="block-wrapper {blok/item/@section-handle}-wrapper">
            <xsl:apply-templates select="yakor"/>
            <xsl:apply-templates select="blok/item"/>
        </article>
    </xsl:template>

    <xsl:template match="/data/page-blocks/entry[tip/item/@handle = 'aside']">
        <xsl:choose>
            <xsl:when test="$link = 'catalog'">
                <div class="container">
                    <aside class="block-wrapper {blok/item/@section-handle}-wrapper span3">
                        <xsl:apply-templates select="yakor"/>
                        <xsl:apply-templates select="blok/item"/>
                    </aside>
                    <section class="block-wrapper blok-catalog-wrapper">
                        <xsl:apply-templates select="/data/module-catalog-category/entry" mode="all-items"/>
                    </section>
                </div>
            </xsl:when>
            <xsl:when test="$page-title = 'Главная'">

            </xsl:when>
            <xsl:otherwise>
                <aside class="block-wrapper {blok/item/@section-handle}-wrapper">
                    <xsl:apply-templates select="yakor"/>
                    <xsl:apply-templates select="blok/item"/>
                </aside>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="/data/page-blocks/entry[tip/item/@handle = 'nav']">
        <xsl:choose>
            <xsl:when test="blok/item/@section-handle = 'blok-tag-cloud'">
                <div class="container">
                    <nav class="block-wrapper {blok/item/@section-handle}-wrapper">
                        <ul class="tag-cloud">
                            <xsl:apply-templates select="/data/block-tag-cloud/entry/punkty-menyu/item" mode="tag-cloud" />
                        </ul>
                    </nav>
                </div>
            </xsl:when>
            <xsl:otherwise>
                <nav class="block-wrapper {blok/item/@section-handle}-wrapper">
                    <xsl:apply-templates select="yakor"/>
                    <xsl:apply-templates select="blok/item"/>
                </nav>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="/data/page-blocks/entry[tip/item/@handle = 'header']">
        <header class="block-wrapper {blok/item/@section-handle}-wrapper">
            <div class="measure-wrapper">
                <xsl:apply-templates select="yakor"/>
                <xsl:apply-templates select="blok/item"/>
            </div>
        </header>
    </xsl:template>

    <xsl:template match="/data/page-blocks/entry[tip/item/@handle = 'footer']">
        <footer class="block-wrapper {blok/item/@section-handle}-wrapper">
            <div class="container">
                <div id="remark-logo" >
                    <a href="http://remark72.ru" target="_blank">
                        <img src="{$workspace}/images/logo_remark.png" />
                    </a>
                </div>
                <div class="footer-menu">
                    <xsl:apply-templates select="/data/block-menu-custom/entry"/>
                </div>
                <div class="content clearfix">
                    <xsl:apply-templates select="/data/block-footer"/>
                </div>
                <!-- <xsl:apply-templates select="yakor"/>
              <xsl:apply-templates select="blok/item"/> -->
            </div>
        </footer>
    </xsl:template>

    <!-- footer menu template -->
    <xsl:template match="/data/block-menu-custom/entry">
        <nav class="navbar navbar-fixed-top">
            <div class="container">
                <xsl:apply-templates select="elementy"/>
            </div>
        </nav>
    </xsl:template>
    <xsl:template match="/data/block-menu-custom/entry/elementy">
        <ul class="nav">
            <xsl:apply-templates select="item"/>
        </ul>
    </xsl:template>
    <xsl:template match="/data/block-menu-custom/entry/elementy/item">
        <xsl:variable name="podstroka" select="concat(ssylka,'/')" />
        <xsl:variable name="stroka" select="string(/data/params/current-path)" />
        <xsl:choose>
            <xsl:when test="concat(ssylka,'/') = /data/params/current-path">
                <li class="active">
                    <a href="{$parent-category}/{ssylka}">
                        <xsl:value-of select="zagolovok" disable-output-escaping="yes"/>
                    </a>
                </li>
            </xsl:when>
            <xsl:otherwise>
                <li>
                    <a href="{$parent-category}/{ssylka}">
                        <xsl:value-of select="zagolovok" disable-output-escaping="yes"/>
                    </a>
                </li>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <!-- Footer tabs -->
    <xsl:template match="/data/block-footer" >
        <div class="opisanie span4">
            <xsl:value-of select="entry/opisanie" disable-output-escaping="yes"/>
        </div>
        <div class="tabs right-tabs">
            <ul class="nav nav-tabs">
                <xsl:apply-templates select="entry/menyu/item" mode="heading" />
            </ul>
            <div class="tab-content">
                <xsl:apply-templates select="entry/menyu/item" mode="content" />
            </div>
        </div>
    </xsl:template>

    <!-- footer-heading-content -->
    <xsl:template match="/data/block-footer/entry/menyu/item" mode="heading">
        <li class="">
            <a href="#{ssylka}" data-toggle="tab" id="{ssylka}">
                <xsl:value-of select="zagolovok" disable-output-escaping="yes"/>
            </a>
        </li>
    </xsl:template>

    <!-- footer-tab-content -->
    <xsl:template match="/data/block-footer/entry/menyu/item" mode="content">
        <div class="tab-pane fade" id="{ssylka}">
            <p>
                <xsl:value-of select="soderzhimoe-slajda" disable-output-escaping="yes"/>
            </p>
        </div>
    </xsl:template>

    <!-- Unknown or Block -->
    <xsl:template match="/data/*"></xsl:template>

    <!-- Блок: Header -->
    <xsl:template match="/data/page-blocks/entry/blok/item[@section-handle='blok-header']">
        <xsl:apply-templates select="/data/block-header/entry[@id = current()/@id]"/>
    </xsl:template>
    <xsl:template match="/data/block-header/entry">
        <div class="container">
            <div class="row head">
                <div class="span6">
                    <a href="/">
                        <img class="block-header-logo" src="{$workspace}{logotip/@path}/{logotip/filename}"
                             alt="{$website-name}"/>
                    </a>
                </div>
                <div class="right-tabs">
                    <xsl:apply-templates select="menyu"/>
                </div>
            </div>
        </div>

    </xsl:template>
    <xsl:template match="/data/block-header/entry/menyu">
        <ul class="nav nav-tabs">
            <xsl:apply-templates select="item"/>
        </ul>
        <div class="tab-content">
            <xsl:apply-templates select="item" mode="content" />
        </div>
    </xsl:template>
    <xsl:template match="/data/block-header/entry/menyu/item">
        <li class="tabs">
            <a href="#{ssylka}" id="{ssylka}" data-toggle="tab">
                <xsl:value-of select="zagolovok" disable-output-escaping="yes"/>
            </a>
        </li>
    </xsl:template>
    <xsl:template match="/data/block-header/entry/menyu/item" mode="content">
        <div class="tab-pane fade" id="{ssylka}">
            <p>
                <xsl:value-of select="soderzhimoe-slajda[@mode='formatted']" disable-output-escaping="yes"/>
            </p>
        </div>
    </xsl:template>

    <!-- Блок: Menu custom -->
    <xsl:template match="/data/page-blocks/entry/blok/item[@section-handle='blok-menu-custom']">
        <xsl:apply-templates select="/data/block-menu-custom/entry[@id = current()/@id]"/>
    </xsl:template>
    <xsl:template match="/data/block-menu-custom/entry">
        <nav class="navbar navbar-fixed-top">
            <div class="container">
                <xsl:apply-templates select="elementy"/>
            </div>
        </nav>
    </xsl:template>
    <xsl:template match="/data/block-menu-custom/entry/elementy">
        <ul class="nav">
            <xsl:apply-templates select="item"/>
        </ul>
    </xsl:template>
    <xsl:template match="/data/block-menu-custom/entry/elementy/item">
        <xsl:variable name="podstroka" select="concat(ssylka,'/')" />
        <xsl:variable name="stroka" select="string(/data/params/current-path)" />
        <xsl:choose>
            <xsl:when test="contains($stroka, $podstroka)">
                <li class="active">
                    <a href="{ssylka}">
                        <xsl:value-of select="zagolovok" disable-output-escaping="yes"/>
                    </a>
                </li>
            </xsl:when>
            <xsl:otherwise>
                <li>
                    <a href="{ssylka}">
                        <xsl:value-of select="zagolovok" disable-output-escaping="yes"/>
                    </a>
                </li>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>


    <!-- Блок: Clients -->
    <xsl:template match="/data/page-blocks/entry/blok/item[@section-handle='blok-clients']">
        <xsl:apply-templates select="/data/block-clients/entry[@id = current()/@id]"/>
    </xsl:template>
    <xsl:template match="/data/block-clients/entry">
        <div class="container">
            <h1>
                <xsl:value-of select="zagolovok" disable-output-escaping="yes"/>
            </h1>
            <ul class="block-clients row">
                <xsl:apply-templates select="elementy/item"/>
            </ul>
        </div>
    </xsl:template>
    <xsl:template match="/data/block-clients/entry/elementy/item">
        <li class="span3 block-clients-item">
            <a href="{ssylka-na-sajt}" title="{nazvanie}" target="_blank">
                <xsl:apply-templates select="izobrazhenie" mode="img">
                    <xsl:with-param name="w" select="'260'"/>
                    <xsl:with-param name="h" select="'180'"/>
                    <xsl:with-param name="alt" select="nazvanie"/>
                </xsl:apply-templates>
            </a>
        </li>
    </xsl:template>

    <!-- Блок: Reviews -->
    <xsl:template match="/data/page-blocks/entry/blok/item[@section-handle='blok-reviews']">
        <xsl:apply-templates select="/data/block-reviews/entry[@id = current()/@id]"/>
    </xsl:template>
    <xsl:template match="/data/block-reviews/entry">
        <div class="container">
            <h1>
                <xsl:value-of select="zagolovok" disable-output-escaping="yes"/>
            </h1>
            <ul class="thumbnails">
                <xsl:apply-templates select="elementy/item"/>
            </ul>
        </div>
    </xsl:template>
    <xsl:template match="/data/block-reviews/entry/elementy/item">
        <li class="span6 block-reviews-item">
            <div class="row">
                <div class="span2">
                    <div class="wrapper">
                        <div class="thumbnail">
                            <a href="{ssylka-na-sajt}" target="_blank">
                                <xsl:apply-templates select="izobrazhenie" mode="img">
                                    <xsl:with-param name="w" select="'260'"/>
                                    <xsl:with-param name="h" select="'180'"/>
                                </xsl:apply-templates>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="span4">
                    <div class="wrapper">
                        <h4>
                            <xsl:value-of select="fio"/>
                            <br/>
                            <small>
                                <xsl:value-of select="dolzhnost"/>
                            </small>
                        </h4>
                        <xsl:value-of select="otzyv[@mode='formatted']" disable-output-escaping="yes"/>
                    </div>
                </div>
            </div>
        </li>
    </xsl:template>

    <!--Block: Slider tabs -->
    <xsl:decimal-format grouping-separator=" " decimal-separator="," name="block-slider-tabs-price"/>
    <xsl:template match="/data/page-blocks/entry/blok/item[@section-handle='blok-slider-tabs']">
        <xsl:apply-templates select="/data/block-slider-tabs/entry[@id = current()/@id]"/>
    </xsl:template>
    <xsl:template match="/data/block-slider-tabs/entry">
        <xsl:variable name="slider.id" select="concat('block-slider-tabs-slider-',@id)"/>
        <xsl:variable name="tabs.id" select="concat('block-slider-tabs-tabs-',@id)"/>
        <div class="container">
            <h1>
                <xsl:value-of select="zagolovok" disable-output-escaping="yes"/>
            </h1>
            <div id="block-slider-tabs-tabs-{@id}">
                <ul class="block-slider-tabs-tabs">
                    <xsl:apply-templates select="elementy/item" mode="header"/>
                </ul>
                <div id="block-slider-tabs-slider-{@id}" class="block-slider-tabs-slider">
                    <xsl:attribute name="style">margin-left:<xsl:value-of select="(100 div elementy/@items) div 2"/>%;margin-right:
                        <xsl:value-of
                                select="(100 div elementy/@items) div 2"/>%;
                    </xsl:attribute>
                </div>
                <xsl:apply-templates select="elementy/item"/>
            </div>
            <script>
                $(function() {
                $( "#<xsl:value-of select="$tabs.id"/>" ).tabs({
                select: function( event, ui ) {
                $( "#<xsl:value-of select="$slider.id"/>" ).slider( "value", ui.index );
                }
                });
                $( "#<xsl:value-of select="$slider.id"/>" ).slider({
                min: 0,
                max: $( "#<xsl:value-of select="$tabs.id"/>" ).tabs( "length" ) - 1,
                slide: function( event, ui ) {
                $( "#<xsl:value-of select="$tabs.id"/>" ).tabs( "select", ui.value );
                }
                });
                });
            </script>
        </div>
    </xsl:template>
    <xsl:template match="/data/block-slider-tabs/entry/elementy/item">
        <div id="block-slider-tabs-tab-{@id}">
            <xsl:value-of select="soderzhanie[@mode='formatted']" disable-output-escaping="yes"/>
        </div>
    </xsl:template>
    <xsl:template match="/data/block-slider-tabs/entry/elementy/item" mode="header">
        <li class="tab-{position()}">
            <xsl:attribute name="style">left:<xsl:value-of
                    select="(100 div ../@items) * (position() - 1)"/>%;width:<xsl:value-of
                    select="(100 div ../@items)"/>%
            </xsl:attribute>
            <a href="#block-slider-tabs-tab-{@id}">
                <xsl:value-of select="zagolovok" disable-output-escaping="yes"/>
            </a>
            <span class="price">
                <xsl:value-of
                        select="concat(format-number(chislo-na-slajdere,'### ###', 'block-slider-tabs-price'),' P')"/>
            </span>
        </li>
    </xsl:template>

    <!-- Блок каталог категорий -->
    <xsl:template match="/data/page-blocks/entry/blok/item[@section-handle='blok-catalog-category']">
        <xsl:choose>
            <!-- Первый уровень меню -->
            <xsl:when test="$link = 'catalog' and string-length($category) = 0 and string-length($product) = 0">
                <ul class="parent">
                    <xsl:apply-templates select="/data/module-catalog-category/entry" mode="level-first" />
                </ul>
            </xsl:when>
            <!-- Второй уровень меню -->
            <xsl:when test="$link = 'catalog' and string-length($category) &gt; 0 and string-length($product) = 0 ">
                <ul class="parent">
                    <xsl:apply-templates select="/data/module-catalog-category/entry" mode="level-second" />
                </ul>
            </xsl:when>
            <!-- Третий уровень меню -->
            <xsl:when test="$link = 'catalog' and string-length($category) &gt; 0 and string-length($product) &gt; 0">
                <ul class="parent">
                    <xsl:apply-templates select="/data/module-catalog-category/entry" mode="level-third" />
                </ul>
            </xsl:when>
        </xsl:choose>
    </xsl:template>

    <!-- Первый уровень меню -->
    <xsl:template match="/data/module-catalog-category/entry" mode="level-first">
        <xsl:variable name="page.categoryid" select="./@id" />
        <xsl:variable name="category.items" select="privyazka-k-tovaru/@items" />
        <xsl:variable name="category.children.length" select="count(children/entry)" />
        <xsl:variable name="page.category" select="category/@handle" />
        <xsl:if test="$category.items = 0 and $category.children.length &gt; 0">
            <li>
                <a href="catalog/{concat($page.category, '--', $page.categoryid)}">
                    <xsl:value-of select="category"/>
                </a>
            </li>
        </xsl:if>
    </xsl:template>

    <!-- Второй уровень меню -->
    <xsl:template match="/data/module-catalog-category/entry" mode="level-second">
        <xsl:variable name="parent-catalog-id" select="substring-after($category, '--')" />
        <xsl:variable name="page.categoryid" select="./@id" />
        <xsl:variable name="page.category" select="category/@handle" />
        <xsl:variable name="category.items" select="privyazka-k-tovaru/@items" />
        <xsl:variable name="category.children.length" select="count(children/entry)" />
        <xsl:choose>
            <!-- Когда выбрана категория товара первого уровня -->
            <xsl:when test="$category.items = 0 and $category.children.length &gt; 0">
                <xsl:choose>
                    <xsl:when test="$page.categoryid = $parent-catalog-id">
                        <li class="active">
                            <a href="catalog/{concat($page.category, '--', $page.categoryid)}"><span class="sprite-left sprite"></span><span class="sprite-mid sprite"><span class="containment"><xsl:value-of select="category"/></span></span><span class="sprite-right sprite"></span></a>
                            <ul class="children">
                                <xsl:apply-templates select="children/entry" mode="level-second-child" />
                            </ul>
                        </li>
                    </xsl:when>
                    <xsl:when test="children/entry/@id = $parent-catalog-id">
                        <li class="">
                            <a href="catalog/{concat($page.category, '--', $page.categoryid)}"><span class="sprite-left sprite"></span><span class="sprite-mid sprite"><span class="containment"><xsl:value-of select="category"/></span></span><span class="sprite-right sprite"></span></a>
                            <ul class="children">
                                <xsl:apply-templates select="children/entry" mode="level-second-child-category" />
                            </ul>
                        </li>
                    </xsl:when>
                    <xsl:otherwise>
                        <li>
                            <a href="catalog/{concat($page.category, '--', $page.categoryid)}">
                                <xsl:value-of select="category"/>
                            </a>
                        </li>
                    </xsl:otherwise>
                </xsl:choose>
            </xsl:when>
        </xsl:choose>
    </xsl:template>

    <!-- Третий уровень меню -->
    <xsl:template match="/data/module-catalog-category/entry" mode="level-third">
        <xsl:variable name="parent-catalog-id" select="substring-after($category, '--')" />
        <xsl:variable name="page.categoryid" select="./@id" />
        <xsl:variable name="page.category" select="category/@handle" />
        <xsl:variable name="category.items" select="privyazka-k-tovaru/@items" />
        <xsl:variable name="category.children.length" select="count(children/entry)" />
        <xsl:choose>
            <!-- Когда выбрана категория товара первого уровня -->
            <xsl:when test="$category.items = 0 and $category.children.length &gt; 0">
                <xsl:choose>
                    <xsl:when test="$page.categoryid = $parent-catalog-id">
                        <li class="active">
                            <a href="catalog/{concat($page.category, '--', $page.categoryid)}"><span class="sprite-left sprite"></span><span class="sprite-mid sprite"><xsl:value-of select="category"/></span><span class="sprite-right sprite"></span></a>
                            <ul class="children">
                                <xsl:apply-templates select="children/entry" mode="level-second-child" />
                            </ul>
                        </li>
                    </xsl:when>
                    <xsl:when test="children/entry/@id = $parent-catalog-id">
                        <li class="">
                            <a href="catalog/{concat($page.category, '--', $page.categoryid)}"><span class="sprite-left sprite"></span><span class="sprite-mid sprite"><xsl:value-of select="category"/></span><span class="sprite-right sprite"></span></a>
                            <ul class="children">
                                <xsl:apply-templates select="children/entry" mode="level-second-child-category" />
                            </ul>
                        </li>
                    </xsl:when>
                    <xsl:otherwise>
                        <li>
                            <a href="catalog/{concat($page.category, '--', $page.categoryid)}">
                                <xsl:value-of select="category"/>
                            </a>
                        </li>
                    </xsl:otherwise>
                </xsl:choose>
            </xsl:when>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="children/entry" mode="level-second-child">
        <xsl:variable name="parent-catalog-id" select="substring-after($category, '--')" />
        <xsl:variable name="child.category" select="category/@handle" />
        <xsl:variable name="child.id" select="./@id" />
        <xsl:variable name="items.count" select="count(/data/module-catalog-category/entry[@id = $child.id]/privyazka-k-tovaru/item)" />
        <xsl:choose>
            <xsl:when test="count(children/entry) > 0">
                <li class="">
                    <a href="catalog/{concat($child.category, '--', $child.id)}">
                        <xsl:value-of select="concat(category, ' (', $items.count, ')')"/>
                    </a>
                </li>
            </xsl:when>
            <xsl:otherwise>
                <li class="">
                    <a href="catalog/{concat($child.category, '--', $child.id)}">
                        <xsl:value-of select="concat(category, ' (', $items.count, ')')"/>
                    </a>
                </li>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="children/entry" mode="level-second-child-category">
        <xsl:variable name="parent-catalog-id" select="substring-after($category, '--')" />
        <xsl:variable name="child.category" select="category/@handle" />
        <xsl:variable name="child.id" select="./@id" />
        <xsl:variable name="items.count" select="count(/data/module-catalog-category/entry[@id = $child.id]/privyazka-k-tovaru/item)" />
        <xsl:choose>
            <xsl:when test="count(children/entry) > 0 and $child.id = $parent-catalog-id">
                <li class="active">
                    <a href="catalog/{concat($child.category, '--', $child.id)}">
                        <span class="sprite-left sprite"></span><span class="sprite-mid sprite"><span class="containment"><xsl:value-of select="concat(category, ' (', $items.count, ')')"/></span></span><span class="sprite-right sprite"></span>
                    </a>
                </li>
            </xsl:when>
            <xsl:when test="count(children/entry) = 0 and $child.id = $parent-catalog-id">
                <li class="active">
                    <a href="catalog/{concat($child.category, '--', $child.id)}">
                        <span class="sprite-left sprite"></span><span class="sprite-mid sprite"><span class="containment"><xsl:value-of select="concat(category, ' (', $items.count, ')')"/></span></span><span class="sprite-right sprite"></span>
                    </a>
                </li>
            </xsl:when>
            <xsl:otherwise>
                <li class="">
                    <a href="/catalog/{concat($child.category, '--', $child.id)}">
                        <xsl:value-of select="concat(category, ' (', $items.count, ')')"/>
                    </a>
                </li>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="children/entry" mode="level-third-child-category">
        <xsl:variable name="parent-catalog-id" select="substring-after($category, '--')" />
        <xsl:variable name="product.category" select="category/@handle" />
        <xsl:variable name="product.id" select="substring-after($product, '--')" />
        <xsl:variable name="child.category" select="category/@handle" />
        <xsl:variable name="child.id" select="./@id" />
        <xsl:choose>
            <xsl:when test="count(children/entry) > 0 and $child.id = $parent-catalog-id">
                <li>
                    <a href="/catalog/{concat($child.category, '--', $child.id)}">
                        <span class="sprite-left sprite"></span><span class="sprite-mid sprite"><span class="containment"><xsl:value-of select="category"/></span></span><span class="sprite-right sprite"></span>
                    </a>
                    <ul class="children">
                        <xsl:apply-templates select="children/entry" mode="test" />
                    </ul>
                </li>
            </xsl:when>
            <xsl:when test="count(children/entry) = 0 and $child.id = $parent-catalog-id">
                <li>
                    <a href="/catalog/{concat($child.category, '--', $child.id)}">
                        <span class="sprite-left sprite"></span><span class="sprite-mid sprite"><span class="containment"><xsl:value-of select="category"/></span></span><span class="sprite-right sprite"></span>
                    </a>
                    <ul class="children">
                        <xsl:apply-templates select="/data/module-catalog-category/entry[@id = $child.id]/privyazka-k-tovaru[@items &gt; 0]/item" mode="products-third"  />
                    </ul>
                </li>
            </xsl:when>
            <xsl:otherwise>
                <li class="">
                    <a href="/catalog/{concat($child.category, '--', $child.id)}">
                        <xsl:value-of select="category"/>
                        <xsl:if test="eto-tovar = 'No'">
                            <xsl:value-of select="concat(' (', count(children/entry), ')')" />
                        </xsl:if>
                    </a>
                </li>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <!-- mode= test -->
    <xsl:template match="/data/module-catalog-category/entry/children/entry/children/entry" mode="test" >
        <xsl:variable name="parent.category" select="../../category/@handle" />
        <xsl:variable name="parent.id" select="substring-after($category, '--')" />
        <xsl:variable name="child.category" select="category/@handle" />
        <xsl:variable name="entry.id" select="./@id" />
        <xsl:variable name="child.id" select="/data/module-catalog-category/entry[@id = $entry.id]/privyazka-k-tovaru/item/@id" />
        <li>
            <a href="/catalog/{concat($parent.category,'--',$parent.id)}/{concat($child.category, '--', $child.id)}">
                <xsl:value-of select="category" /></a>
        </li>
    </xsl:template>

    <!-- mode= products -->
    <xsl:template match="/data/module-catalog-category/entry/privyazka-k-tovaru/item" mode="products" >
        <xsl:variable name="parent.category" select="../../category/@handle" />
        <xsl:variable name="parent.id" select="substring-after($category, '--')" />
        <xsl:variable name="child.category" select="zagolovok/@handle" />
        <xsl:variable name="child.id" select="./@id" />
        <li>
            <a href="/catalog/{concat($parent.category,'--',$parent.id)}/{concat($child.category, '--', $child.id)}">
                <xsl:value-of select="zagolovok" /></a>
        </li>
    </xsl:template>

    <!-- mode= products-third -->
    <xsl:template match="/data/module-catalog-category/entry/privyazka-k-tovaru/item" mode="products-third" >
        <xsl:variable name="parent.category" select="../../category/@handle" />
        <xsl:variable name="parent.id" select="substring-after($category, '--')" />
        <xsl:variable name="product.id" select="substring-after($product, '--')" />
        <xsl:variable name="child.category" select="zagolovok/@handle" />
        <xsl:variable name="child.id" select="./@id" />
        <xsl:choose>
            <xsl:when test="$child.id = $product.id">
                <li class="active">
                    <a href="/catalog/{concat($parent.category,'--',$parent.id)}/{concat($child.category, '--', $child.id)}"><span class="sprite-left sprite"></span><span class="sprite-mid sprite"><xsl:value-of select="zagolovok"/></span><span class="sprite-right sprite"></span></a>
                </li>
            </xsl:when>
            <xsl:otherwise>
                <li>
                    <a href="/catalog/{concat($parent.category,'--',$parent.id)}/{concat($child.category, '--', $child.id)}">
                        <xsl:value-of select="zagolovok" /></a>
                </li>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <!-- Левое меню -->
    <xsl:template match="/data/module-catalog-category/entry" mode="default">
        <xsl:variable name="page.categoryid" select="./@id" />
        <xsl:variable name="page.category" select="category/@handle" />
        <xsl:if test="otobrazhat-na-pervom-urovne = 'Yes'">
            <li>
                <a href="catalog/{concat($page.category, '--', $page.categoryid)}">
                    <xsl:value-of select="category"/>
                </a>
                <xsl:choose>
                    <!-- Первый уровень каталога -->
                    <xsl:when test="count(children/entry) &gt; 0
               and $link = 'catalog' and string-length($category) = 0
               and string-length($product) = 0">
                    </xsl:when>
                    <!-- Второй уровень каталога -->
                    <xsl:when test="count(children/entry) &gt; 0
               and $link = 'catalog' and string-length($category) &gt; 0
               and string-length($product) = 0 ">
                        <ul class="children">
                            <xsl:apply-templates select="children/entry" mode="catalog" />
                        </ul>
                    </xsl:when>
                    <!-- Третий уровень каталога, уровень товара -->
                    <xsl:when test="count(children/entry) &gt; 0
               and $link = 'catalog' and string-length($category) &gt; 0
               and string-length($product) &gt; 0">
                        <ul class="children">
                            <xsl:apply-templates select="children/entry" mode="catalog" />
                        </ul>
                    </xsl:when>
                </xsl:choose>
            </li>
        </xsl:if>
    </xsl:template>

    <xsl:template match="children/entry" mode="product">
        <xsl:variable name="parent.category" select="../../category/@handle" />
        <xsl:variable name="child.category" select="category/@handle" />
        <xsl:variable name="child.id" select="./@id" />

        <xsl:choose>
            <xsl:when test="count(children/entry) > 0">
                <li class="have-child-products">
                    <a href="/catalog/{concat($child.category, '--', $child.id)}">
                        <xsl:value-of select="category"/>
                        <xsl:value-of select="concat(' (', count(children/entry), ')')" />
                    </a>
                    <ul class="children deeper">
                        <xsl:apply-templates select="children/entry" mode="product">
                        </xsl:apply-templates>
                    </ul>
                </li>
            </xsl:when>
            <xsl:otherwise>
                <li>
                    <a href="/catalog/{concat($child.category, '--', $child.id)}">
                        <xsl:value-of select="category"/>
                        <xsl:value-of select="concat(' (', count(children/entry), ')')" />
                    </a>
                </li>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="children/entry" mode="product">
        <xsl:variable name="parent.category" select="../../category/@handle" />
        <xsl:variable name="child.category" select="category/@handle" />
        <xsl:variable name="child.id" select="./@id" />

        <li class="active">
            <div class="sprite-top sprite"></div>
            <a href="/catalog/{concat($child.category, '--', $child.id)}" class="sprite-mid sprite">
                <span class="containment"><xsl:value-of select="concat(category,' (', count(children/entry), ')')" /></span></a><div class="sprite-bot sprite"></div>
        </li>
    </xsl:template>

    <!-- Module: Goods -->
    <xsl:template match="/data/module-catalog-category/entry" mode="all-items">
        <xsl:variable name="selectFromCategory" select="./@id" />
        <xsl:choose>
            <!-- Первый уровень каталога -->
            <xsl:when test="$link = 'catalog' and string-length($category) = 0 and string-length($product) = 0">
                <xsl:apply-templates select="/data/module-catalog-category/entry[@id = $selectFromCategory]/privyazka-k-tovaru[@items &gt; 0]" mode="level-catalog" >
                    <xsl:sort data-type="text" order="ascending" select="../@handle" />
                </xsl:apply-templates>
            </xsl:when>
            <!-- Второй уровень каталога -->
            <xsl:when test="$link = 'catalog' and string-length($category) &gt; 0 and string-length($product) = 0 and $selectFromCategory = substring-after($category, '--')">
                <xsl:variable name="category.id" select="substring-after($category, '--')" />
                <xsl:apply-templates select="/data/module-catalog-category/entry[@id = $category.id]" mode="level-category" />
            </xsl:when>
            <!-- Третий уровень каталога - уровень товара -->
            <xsl:when test="$link = 'catalog' and string-length($category) &gt; 0 and string-length($product) &gt; 0 and $selectFromCategory = substring-after($category, '--')">
                <xsl:variable name="category.id" select="substring-after($category, '--')" />
                <xsl:variable name="product.id" select="substring-after($product, '--')" />
                <xsl:apply-templates select="/data/module-catalog-category/entry[@id = $category.id]/privyazka-k-tovaru[@items &gt; 0]/item[@id = $product.id]" mode="level-product" />
            </xsl:when>
        </xsl:choose>
    </xsl:template>



    <!-- Каталог шаблон каталога -->
    <xsl:template match="/data/module-catalog-category/entry/privyazka-k-tovaru" mode="level-catalog">
        <xsl:variable name="category" select="../category/@handle" />
        <xsl:variable name="categoryid" select="../@id" />
        <!-- Here comes the section header -->
        <hgroup class="level-catalog">
            <h1>
                <xsl:value-of select="../category" />
            </h1>
        </hgroup>
        <xsl:apply-templates select="/data/module-catalog-category/entry[@id = $categoryid]/privyazka-k-tovaru[@items &gt; 0]/item" />

        <xsl:if test="./@items &gt; 0">
            <p class="show-all" >
                <a href="/catalog/{concat($category, '--', $categoryid)}">Просмотреть все</a>
            </p>
        </xsl:if>
    </xsl:template>

    <!-- Here comes the item block -->
    <xsl:template match="/data/module-catalog-category/entry/privyazka-k-tovaru/item" >
        <xsl:variable name="category" select="../../category/@handle" />
        <xsl:variable name="categoryid" select="../../@id" />
        <xsl:value-of select="../@id" />
        <xsl:variable name="product" select="zagolovok/@handle" />
        <xsl:variable name="productid" select="./@id" />
        <xsl:if test="position() &lt; 4" >
            <div class="item">
                <figure>
                    <a href="/catalog/{concat($category, '--', $categoryid)}/{concat($product, '--', $productid)}" class="product-link-price">
                        <p class="price">
                            <xsl:value-of select="format-number(tsena, '### ###', 'rur')"/>
                            <span class="rur">a</span><span class="asterisk">*</span>
                        </p>
                    </a>
                    <a href="/catalog/{concat($category, '--', $categoryid)}/{concat($product, '--', $productid)}" class="product-link">
                        <xsl:call-template name="img">
                            <xsl:with-param name="upload" select="izobrazhenie"/>
                            <xsl:with-param name="w" select="165"/>
                            <xsl:with-param name="class" select="'img'"/>
                        </xsl:call-template>
                    </a>
                </figure>
                <div class="description">
                    <h2>
                        <xsl:value-of select="zagolovok" />
                    </h2>
                    <p>
                        <xsl:choose>
                            <xsl:when test="string-length(detalnoe-opisanie[@mode = 'formatted'] &gt; $readMoreLimit)">
                                <xsl:variable select ="substring(detalnoe-opisanie[@mode = 'formatted'], 1, $readMoreLimit)" name="readMore" />
                                <xsl:value-of select="concat($readMore , ' ...')" disable-output-escaping="yes" />
                            </xsl:when>
                            <xsl:otherwise>
                                <xsl:value-of select="detalnoe-opisanie[@mode = 'formatted']" disable-output-escaping="yes" />
                            </xsl:otherwise>
                        </xsl:choose>
                    </p>
                </div>
                <div class="popup">
                    <img src="{$workspace}/images/podskazka-strelka.png" class="pointer" />
                    <p><span class="asterisk">*</span>цена может измениться, для уточнения свяжитесь с менеджером.</p>
                </div>
                <a href="/catalog/{concat($category, '--', $categoryid)}/{concat($product, '--', $productid)}" class="product-detail">Подробнее</a>
            </div>
        </xsl:if>
    </xsl:template>

    <!-- Каталог шаблон категории -->
    <xsl:template match="entry" mode="level-category">
        <xsl:variable name="category.link" select="$category" />
        <xsl:variable name="category.id" select="substring-after($category.link, '--')" />
        <!-- We just wanna make sure that we got proper link -->
        <xsl:if test="contains($category.link, $category.id)">
            <xsl:variable name="haveChildSections" select="count(/data/module-catalog-category/entry[@id = $category.id]/children/entry)" />
            <xsl:variable name="donthaveChildSections" select="count(/data/module-goods/privyazka-k-razdelu[@id = $category.id])" />
            <!-- Вдруг это родительская категория и надо отобразить список дочерних -->
            <xsl:choose>
                <xsl:when test="$haveChildSections &gt; 0">
                    <xsl:choose>
                        <xsl:when test="/data/module-catalog-category/entry[@id = $category.id]/privyazka-k-tovaru/@items = 0">
                            <xsl:apply-templates select="/data/module-catalog-category/entry[@id = $category.id]/children/entry" mode="searchForChild" />
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:call-template name="empty" />
                        </xsl:otherwise>
                    </xsl:choose>
                </xsl:when>
                <!-- Вдруг это дочерняя категория и надо отобразить список товаров -->
                <xsl:when test="$haveChildSections = 0">
                    <xsl:variable name="total" select="/data/module-catalog-category/entry[@id = $category.id]/privyazka-k-tovaru/@items" />
                    <xsl:variable name="total.pages" select="ceiling($total div 10)" />
                    <xsl:variable name="curPage" select="/data/params/url-page" />
                    <xsl:choose>
                        <xsl:when test="$curPage &gt; 0">
                            <xsl:apply-templates select="/data/module-catalog-category/entry[@id = $category.id]/privyazka-k-tovaru" mode="category"/>
                            <!-- pagination -->
                            <xsl:variable name="fake-pagination">
                                <pagination total-entries="{$total}" total-pages="{$total.pages}" entries-per-page="10" current-page="{/data/params/url-page}" />
                            </xsl:variable>
                            <xsl:call-template name="pagination-bar">
                                <xsl:with-param name="pagination" select="exsl:node-set($fake-pagination)/pagination"/>
                            </xsl:call-template>
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:apply-templates select="/data/module-catalog-category/entry[@id = $category.id]/privyazka-k-tovaru" mode="category"/>
                            <!-- pagination -->
                            <xsl:variable name="fake-pagination">
                                <pagination total-entries="{$total}" total-pages="{$total.pages}" entries-per-page="10" current-page="1" />
                            </xsl:variable>
                            <xsl:call-template name="pagination-bar">
                                <xsl:with-param name="pagination" select="exsl:node-set($fake-pagination)/pagination"/>
                            </xsl:call-template>
                        </xsl:otherwise>
                    </xsl:choose>
                </xsl:when>
                <xsl:otherwise>
                    <p>В данной категории еще нет товаров. Попробуйте посмотрить другие.</p>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:if>

    </xsl:template>

    <xsl:template name="pagination-bar">
        <xsl:param name="pagination"/>
        <xsl:variable name="category.id" select="substring-after($category, '--')" />
        <xsl:variable name="category.handle" select="substring-before($category, '--')" />

        <xsl:call-template name="pagination">
            <xsl:with-param name="pagination" select="$pagination" />
            <xsl:with-param name="display-number" select="'2'" />
            <xsl:with-param name="pagination-url" select="concat($root, '/catalog/', $category.handle, '--', $category.id, '/?page=$')"/>
        </xsl:call-template>
    </xsl:template>

    <!-- Включение дочерних категорий в родительскую -->
    <xsl:template match="/data/module-catalog-category/entry/children/entry" mode="searchForChild">
        <xsl:variable name="category.id" select="./@id" />
        <xsl:choose>
            <xsl:when test="/data/module-catalog-category/entry[@id = $category.id]/privyazka-k-tovaru/@items &gt; 0">
                <xsl:apply-templates select="/data/module-catalog-category/entry[@id = $category.id]/privyazka-k-tovaru[@items &gt; 0]" mode="category-three" />
            </xsl:when>
            <xsl:otherwise>

            </xsl:otherwise>
        </xsl:choose>
        <xsl:variable name="category" select="./category/@handle" />
        <xsl:variable name="categoryid" select="./@id" />

        <xsl:if test="/data/module-catalog-category/entry[@id = $category.id]/privyazka-k-tovaru/@items &gt; 0">
            <p class="show-all" >
                <a href="/catalog/{concat($category, '--', $categoryid)}">Просмотреть все</a>
            </p>
        </xsl:if>

    </xsl:template>


    <xsl:template name="empty">
        <hgroup>
            <p class="summary">
                <xsl:call-template name="declension">
                    <xsl:with-param name="number" select="./@items" />
                    <!-- Именительный падеж (изображение) -->
                    <xsl:with-param name="nominative" select="concat(./@items, ' товар')"/>
                    <!-- Родительный падеж, единственное число (изображения) -->
                    <xsl:with-param name="genitive_singular" select="concat(./@items, ' товара')"/>
                    <!-- Родительный падеж, множественное число (изображений) -->
                    <xsl:with-param name="genitive_plural" select="concat(./@items, ' товаров')"/>
                </xsl:call-template>
                <xsl:text> в категории</xsl:text>
            </p>
            <h1>Товары не найдены.</h1>
        </hgroup>
        <p>
            Попробуйте выбрать другую категорию.
        </p>
    </xsl:template>

    <xsl:template match="/data/module-catalog-category/entry/privyazka-k-tovaru" mode="category">
        <xsl:variable name="curPage" select="/data/params/url-page" />
        <xsl:choose>
            <xsl:when test="./@items &gt; 0">
                <xsl:choose>
                    <xsl:when test="$curPage &gt; 0">
                        <xsl:if test="$curPage = 1">
                            <hgroup>
                                <p class="summary">
                                    <xsl:call-template name="declension">
                                        <xsl:with-param name="number" select="./@items" />
                                        <!-- Именительный падеж (изображение) -->
                                        <xsl:with-param name="nominative" select="concat(./@items, ' товар')"/>
                                        <!-- Родительный падеж, единственное число (изображения) -->
                                        <xsl:with-param name="genitive_singular" select="concat(./@items, ' товара')"/>
                                        <!-- Родительный падеж, множественное число (изображений) -->
                                        <xsl:with-param name="genitive_plural" select="concat(./@items, ' товаров')"/>
                                    </xsl:call-template>
                                    <xsl:text> в категории</xsl:text>
                                </p>
                                <h1>
                                    <xsl:value-of select="../category" />
                                </h1>
                            </hgroup>
                        </xsl:if>
                        <xsl:variable name="skipItems" select="$url-page * 10 - 10" />
                        <xsl:apply-templates select="item[position() &gt; $skipItems and position() &lt; $skipItems + 11]" mode="childCategory" />
                    </xsl:when>
                    <xsl:otherwise>
                        <hgroup>
                            <p class="summary">
                                <xsl:call-template name="declension">
                                    <xsl:with-param name="number" select="./@items" />
                                    <!-- Именительный падеж (изображение) -->
                                    <xsl:with-param name="nominative" select="concat(./@items, ' товар')"/>
                                    <!-- Родительный падеж, единственное число (изображения) -->
                                    <xsl:with-param name="genitive_singular" select="concat(./@items, ' товара')"/>
                                    <!-- Родительный падеж, множественное число (изображений) -->
                                    <xsl:with-param name="genitive_plural" select="concat(./@items, ' товаров')"/>
                                </xsl:call-template>
                                <xsl:text> в категории</xsl:text>
                            </p>
                            <h1>
                                <xsl:value-of select="../category" />
                            </h1>
                        </hgroup>
                        <!-- Показывать первые 10 товаров -->
                        <xsl:apply-templates select="item[position() &lt; 11]" mode="childCategory" />
                    </xsl:otherwise>
                </xsl:choose>
            </xsl:when>
            <xsl:otherwise>
                <xsl:call-template name="empty" />
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="/data/module-catalog-category/entry/privyazka-k-tovaru" mode="category-three">
        <xsl:variable name="curPage" select="/data/params/url-page" />
        <xsl:choose>
            <xsl:when test="./@items &gt; 0">
                <xsl:choose>
                    <xsl:when test="$curPage &gt; 2">
                        <hgroup>
                            <p class="summary">
                                <xsl:call-template name="declension">
                                    <xsl:with-param name="number" select="./@items" />
                                    <!-- Именительный падеж (изображение) -->
                                    <xsl:with-param name="nominative" select="concat(./@items, ' товар')"/>
                                    <!-- Родительный падеж, единственное число (изображения) -->
                                    <xsl:with-param name="genitive_singular" select="concat(./@items, ' товара')"/>
                                    <!-- Родительный падеж, множественное число (изображений) -->
                                    <xsl:with-param name="genitive_plural" select="concat(./@items, ' товаров')"/>
                                </xsl:call-template>
                                <xsl:text> в категории</xsl:text>
                            </p>
                            <h1>
                                <xsl:value-of select="../category" />
                            </h1>
                        </hgroup>
                        <xsl:apply-templates select="item[position() > $url-page]" mode="childCategory" />
                    </xsl:when>
                    <xsl:otherwise>
                        <hgroup>
                            <p class="summary">
                                <xsl:call-template name="declension">
                                    <xsl:with-param name="number" select="./@items" />
                                    <!-- Именительный падеж (изображение) -->
                                    <xsl:with-param name="nominative" select="concat(./@items, ' товар')"/>
                                    <!-- Родительный падеж, единственное число (изображения) -->
                                    <xsl:with-param name="genitive_singular" select="concat(./@items, ' товара')"/>
                                    <!-- Родительный падеж, множественное число (изображений) -->
                                    <xsl:with-param name="genitive_plural" select="concat(./@items, ' товаров')"/>
                                </xsl:call-template>
                                <xsl:text> в категории</xsl:text>
                            </p>
                            <h1>
                                <xsl:value-of select="../category" />
                            </h1>
                        </hgroup>
                        <xsl:apply-templates select="item" mode="childCategory-three" />
                    </xsl:otherwise>
                </xsl:choose>
            </xsl:when>
            <xsl:otherwise>
                <xsl:call-template name="empty" />
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="/data/module-catalog-category/entry/privyazka-k-tovaru/item" mode="childCategory">
        <xsl:variable name="category" select="../../category/@handle" />
        <xsl:variable name="categoryid" select="../../@id" />
        <xsl:variable name="product" select="zagolovok/@handle" />
        <xsl:variable name="productid" select="./@id" />

        <!-- Here comes the item block -->
        <div class="item">
            <figure>
                <a class="product-link-price" href="catalog/{concat($category, '--', $categoryid)}/{concat($product, '--', $productid)}">
                    <p class="price">
                        <xsl:value-of select="format-number(tsena, '### ###', 'rur')" />
                        <span class="rur">a</span>
                        <span class="asterisk">*</span>
                    </p>
                </a>
                <a class="product-link" href="catalog/{concat($category, '--', $categoryid)}/{concat($product, '--', $productid)}">
                    <xsl:call-template name="img">
                        <xsl:with-param name="upload" select="izobrazhenie"/>
                        <xsl:with-param name="w" select="165"/>
                        <xsl:with-param name="class" select="'img'"/>
                    </xsl:call-template>
                </a>
            </figure>
            <div class="description">
                <h2>
                    <xsl:value-of select="zagolovok" />
                </h2>
                <p>
                    <xsl:value-of select="concat(substring(detalnoe-opisanie[@mode = 'formatted'], 1, $readMoreLimit), ' ...')" disable-output-escaping="yes" />
                </p>
                <xsl:if test="string-length(artikul) &gt; 0">
                    <p class="sku">Артикул:
                        <xsl:value-of select="artikul" />
                    </p>
                </xsl:if>
                <xsl:if test="string-length(razmery) &gt; 0">
                    <p class="dimensions">Размеры:
                        <xsl:value-of select="razmery" />
                    </p>
                </xsl:if>
            </div>
            <div class="popup">
                <img src="{$workspace}/images/podskazka-strelka.png" class="pointer" />
                <p><span class="asterisk">*</span>цена может измениться, для уточнения свяжитесь с менеджером.</p>
            </div>
            <p class="podrobnee">
                <a class="product-detail" href="catalog/{concat($category, '--', $categoryid)}/{concat($product, '--', $productid)}">
                    Подробнее</a>
            </p>
        </div>
    </xsl:template>

    <xsl:template match="/data/module-catalog-category/entry/privyazka-k-tovaru/item" mode="childCategory-three">
        <xsl:variable name="category" select="../../category/@handle" />
        <xsl:variable name="categoryid" select="../../@id" />
        <xsl:variable name="product" select="zagolovok/@handle" />
        <xsl:variable name="productid" select="./@id" />
        <xsl:if test="position() &lt; 4">
            <!-- Here comes the item block -->
            <div class="item">
                <figure>
                    <a class="product-link-price" href="catalog/{concat($category, '--', $categoryid)}/{concat($product, '--', $productid)}">
                        <p class="price">
                            <xsl:value-of select="format-number(tsena, '### ###', 'rur')" />
                            <span class="rur">a</span>
                            <span class="asterisk">*</span>
                        </p>
                    </a>
                    <a class="product-link" href="catalog/{concat($category, '--', $categoryid)}/{concat($product, '--', $productid)}">
                        <xsl:call-template name="img">
                            <xsl:with-param name="upload" select="izobrazhenie"/>
                            <xsl:with-param name="w" select="165"/>
                            <xsl:with-param name="class" select="'img'"/>
                        </xsl:call-template>
                    </a>
                </figure>
                <div class="description">
                    <h2>
                        <xsl:value-of select="zagolovok" />
                    </h2>
                    <p>
                        <xsl:value-of select="concat(substring(detalnoe-opisanie[@mode = 'formatted'], 1, $readMoreLimit), ' ...')" disable-output-escaping="yes" />
                    </p>
                    <xsl:if test="string-length(artikul) &gt; 0">
                        <p class="sku">Артикул:
                            <xsl:value-of select="artikul" />
                        </p>
                    </xsl:if>
                    <xsl:if test="string-length(razmery) &gt; 0">
                        <p class="dimensions">Размеры:
                            <xsl:value-of select="razmery" />
                        </p>
                    </xsl:if>
                </div>
                <div class="popup">
                    <img src="{$workspace}/images/podskazka-strelka.png" class="pointer" />
                    <p><span class="asterisk">*</span>цена может измениться, для уточнения свяжитесь с менеджером.</p>
                </div>
                <p class="podrobnee">
                    <a class="product-detail" href="catalog/{concat($category, '--', $categoryid)}/{concat($product, '--', $productid)}">
                        Подробнее</a>
                </p>
            </div>
        </xsl:if>
    </xsl:template>

    <!-- Данные в шаблоне категории -->
    <xsl:template match="/data/module-catalog-category/entry/children/entry/privyazka-k-tovaru" mode="category">
        <hgroup>
            <p class="summary">
                <xsl:call-template name="declension">
                    <xsl:with-param name="number" select="./@items" />
                    <!-- Именительный падеж (изображение) -->
                    <xsl:with-param name="nominative" select="concat(./@items, ' товар')"/>
                    <!-- Родительный падеж, единственное число (изображения) -->
                    <xsl:with-param name="genitive_singular" select="concat(./@items, ' товара')"/>
                    <!-- Родительный падеж, множественное число (изображений) -->
                    <xsl:with-param name="genitive_plural" select="concat(./@items, ' товаров')"/>
                </xsl:call-template>
                <xsl:text> в категории</xsl:text>
            </p>
            <h1>
                <xsl:value-of select="category" />
            </h1>
        </hgroup>
        <xsl:apply-templates select="item" mode="childCategory" />
    </xsl:template>

    <xsl:template match="/data/module-catalog-category/entry/children/entry/privyazka-k-tovaru/item" mode="childCategory">
        <xsl:variable name="position" select="position()" />
        <!-- Here comes the item block -->
        <div class="item">
            <figure>
                <p class="price">
                    <xsl:value-of select="format-number(tsena, '### ###', 'rur')" />
                    <span class="rur">a</span><span class="asterisk">*</span></p>
                <xsl:call-template name="img">
                    <xsl:with-param name="upload" select="izobrazhenie"/>
                    <xsl:with-param name="w" select="165"/>
                    <xsl:with-param name="class" select="'img'"/>
                </xsl:call-template>
            </figure>
            <div class="description">
                <h2>
                    <xsl:value-of select="zagolovok" />
                </h2>
                <p>
                    <xsl:value-of select="concat(substring(detalnoe-opisanie[@mode = 'formatted'], 1, $readMoreLimit), ' ...')" disable-output-escaping="yes" />
                </p>
                <xsl:if test="string-length(artikul) &gt; 0">
                    <p class="sku">Артикул:
                        <xsl:value-of select="artikul" />
                    </p>
                </xsl:if>
                <xsl:if test="string-length(razmery) &gt; 0">
                    <p class="dimensions">Размеры:
                        <xsl:value-of select="razmery" />
                    </p>
                </xsl:if>
            </div>
            <div class="popup">
                <img src="{$workspace}/images/podskazka-strelka.png" class="pointer" />
                <p><span class="asterisk">*</span>цена может измениться, для уточнения свяжитесь с менеджером.</p>
            </div>
            <p class="podrobnee">
                <xsl:variable name="category" select="privyazka-k-razdelu/item/category/@handle" />
                <xsl:variable name="categoryid" select="privyazka-k-razdelu/item/@id" />
                <a class="product-detail" href="catalog/{concat($category, '--', $categoryid)}/{concat(zagolovok/@handle, '--', ../entry[$test]/@id)}">
                    Подробнее</a>
            </p>
        </div>
    </xsl:template>

    <!-- Каталог шаблон продукта -->
    <xsl:template match="/data/module-catalog-category/entry/privyazka-k-tovaru/item" mode="level-product">
        <xsl:variable name="product.id" select="substring-after($product, '--')" />
        <hgroup class="level-product">
            <h1>
                <xsl:value-of select="../../category" />
            </h1>
        </hgroup>
        <div class="product">
            <figure>
                <xsl:call-template name="img">
                    <xsl:with-param name="upload" select="izobrazhenie"/>
                    <xsl:with-param name="class" select="'img'"/>
                    <xsl:with-param name="w" select="310"/>
                </xsl:call-template>
                <p class="notice">Фотографии/изображение товара и его описание на сайте могут отличаться от внешнего вида товара.</p>
            </figure>
            <div class="description">
                <h2>
                    <xsl:value-of select="zagolovok" />
                </h2>
                <p class="price">
                    <xsl:value-of select="format-number(tsena, '### ###', 'rur')" />
                    <span class="rur">a</span><span class="asterisk">*</span>
                    <br />
                    <span class="condition">* Цена может отличаться от указаной, уточняйте по телефону.</span>
                </p>
                <p class="opisanie">
                    <xsl:value-of select="detalnoe-opisanie[@mode='formatted']" disable-output-escaping="yes" />
                </p>
                <xsl:if test="string-length(artikul) &gt; 0">
                    <p class="sku">Артикул:
                        <xsl:value-of select="artikul" />
                    </p>
                </xsl:if>
                <xsl:if test="string-length(razmery) &gt; 0">
                    <p class="dimensions">Размеры:
                        <xsl:value-of select="razmery" />
                    </p>
                </xsl:if>
            </div>
        </div>
        <div class="additional-content">
            <h3>Для заказа звоните по телефонам в вашем городе:</h3>
            <ul class="nav nav-pills">
                <!-- -->
                <li class="dropdown" id="city-tyumen">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#tyumen">
                        Тюмень
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#city-ishim" id="city-ishim">Ишим</a></li>
                        <li><a href="#city-yalutorovsk" id="city-yalutorovsk">Ялуторовск</a></li>
                    </ul>
                    <div class="dropdown-content">
                        <p>ул. Минская, дом 53/3<br />
                            (3452) <strong>200-003, 200-900, 200-909</strong></p>
                    </div>
                </li>
                <!-- -->
                <li class="dropdown hidden" id="city-ishim">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#ishim">
                        Ишим
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#city-tyumen" id="city-tyumen">Тюмень</a></li>
                        <li><a href="#city-yalutorovsk" id="city-yalutorovsk">Ялуторовск</a></li>
                    </ul>
                    <div class="dropdown-content">
                        <p>Ишим еще меньше и ок.<br />
                            (3452) 200-003, 200-900, 200-909</p>
                    </div>
                </li>
                <li class="dropdown hidden" id="city-yalutorovsk">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#yalutorovsk">
                        Ялуторовск
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#city-tyumen" id="city-tyumen">Тюмень</a></li>
                        <li><a href="#city-ishim" id="city-ishim">Ишим</a></li>
                    </ul>
                    <div class="dropdown-content">
                        <p>Ялуторовск - маленький город.<br />
                            (3452) <strong>200-003, 200-900, 200-909</strong></p>
                    </div>
                </li>
            </ul>

            <div class="complete-price">
                <xsl:apply-templates select="/data/block-complete-price-list/entry" />
            </div>

            <div class="similar-items">
                <h4>
                    Все доступные
                    <xsl:value-of select="concat(kategoriya-tovara, ':')" />
                </h4>
                <table class="similar-grid">
                    <thead>
                        <tr>
                            <th class="spacer"></th>
                            <th class="nazvanie">название</th>
                            <th class="measure-unit">единица измерения</th>
                            <th class="price">цена</th>
                        </tr>
                    </thead>
                    <tbody>
                        <xsl:variable name="kategoriya-tovara" select="kategoriya-tovara/@handle" />
                        <xsl:apply-templates select="/data/module-catalog-category/entry/privyazka-k-tovaru[@items &gt; 0]/item/kategoriya-tovara[@handle = $kategoriya-tovara]">
                            <xsl:sort data-type="text" select="/data/module-catalog-category/entry/privyazka-k-tovaru[@items &gt; 0]/item/brend" order="ascending" />
                        </xsl:apply-templates>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="new-arrivals">
            <h4>Новые поступления: </h4>
            <xsl:apply-templates select="/data/module-catalog-category/entry/privyazka-k-tovaru[@items &gt; 0]" mode="new-arrivals">
                <xsl:sort data-type="number" order="descending" select="item/@id" />
            </xsl:apply-templates>
        </div>
    </xsl:template>

    <xsl:template match='/data/module-catalog-category/entry/privyazka-k-tovaru/item/kategoriya-tovara'>
        <xsl:variable name="brand" select="../brend" />
        <xsl:variable name="kategoriya-tovara" select="./@handle" />
        <xsl:variable name="position" select="position()" />
        <xsl:variable name="xpath" select="/data/module-catalog-category/entry/privyazka-k-tovaru[@items &gt; 0]/item/kategoriya-tovara[@handle = $kategoriya-tovara]" />
        <xsl:for-each select="$xpath[$position]/.." >
            <xsl:sort data-type="text" order="descending" select="./brend"/>
            <xsl:variable name="brand.each">
                <xsl:choose>
                    <xsl:when test="true()">
                        <xsl:value-of select="./brend" />
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:value-of select="'бренд не указан'" />
                    </xsl:otherwise>
                </xsl:choose>
            </xsl:variable>
            <xsl:variable name="position.each" select="position()" />
            <xsl:variable name="brand.previous.each" select="$xpath[$position - 1]/../brend" />
            <xsl:variable name="brand.next.each" select="$xpath[$position + 1]/../brend" />
            <xsl:variable name="brand.gorod" select="./gorod" />
            <xsl:variable name="brand.strana" select="./strana-proishozhdeniya" />
            <xsl:choose>
                <xsl:when test="not($brand.each = $brand.previous.each)">
                    <tr>
                        <td></td>
                        <td class="desc">
                            <span class="brand">
                                <xsl:choose>
                                    <xsl:when test="string-length($brand.each) &gt; 0" >
                                        <xsl:value-of select="$brand.each "/>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        <xsl:text>бренд не указан</xsl:text>
                                    </xsl:otherwise>
                                </xsl:choose>
                            </span>,
                            <xsl:choose>
                                <xsl:when test="string-length($brand.strana) &gt; 0" >
                                    <xsl:value-of select="$brand.strana"/>
                                </xsl:when>
                                <xsl:when test="string-length($brand.gorod) &gt; 0" >
                                    <xsl:value-of select="$brand.gorod"/>
                                </xsl:when>
                                <xsl:otherwise>
                                    <xsl:text>страна происхождения не указана</xsl:text>
                                </xsl:otherwise>
                            </xsl:choose>
                        </td>
                    </tr>
                </xsl:when>
                <!-- Сие бекап есть, зело полезный
                 <xsl:when test="false()">
                    <tr>
                        <td></td>
                        <td class="desc">
                            <span class="brand">
                                <xsl:choose>
                                    <xsl:when test="string-length($brand.each) &gt; 0" >
                                        <xsl:value-of select="$brand.each "/>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        <xsl:text>бренд не указан</xsl:text>
                                    </xsl:otherwise>
                                </xsl:choose>
                            </span>,
                            <xsl:choose>
                                <xsl:when test="string-length($brand.strana) &gt; 0" >
                                    <xsl:value-of select="$brand.strana"/>
                                </xsl:when>
                                <xsl:when test="string-length($brand.gorod) &gt; 0" >
                                    <xsl:value-of select="$brand.gorod"/>
                                </xsl:when>
                                <xsl:otherwise>
                                    <xsl:text>страна происхождения не указана</xsl:text>
                                </xsl:otherwise>
                            </xsl:choose>
                        </td>
                    </tr>
                </xsl:when>
                                     <pre>
                        <xsl:value-of select="concat($position,'.: ',$brand.previous.each, '-', $brand.each, '-', $brand.next.each)" />
                    </pre>
                 -->
            </xsl:choose>
            <tr>
                <td class="spacer"></td>
                <td class="tovar">
                    <a href="catalog/{$category}/{./zagolovok/@handle}--{./@id}">
                        <xsl:value-of select="./zagolovok" />
                    </a>
                </td>
                <td class="measure-unit">шт.</td>
                <td class="price">
                    <xsl:variable name="fprice" select="format-number(./tsena, '### ###', 'rur')" />
                    <xsl:value-of select="concat($fprice, '-00')" />
                    <span class="rur">a</span>
                </td>
            </tr>
            <!--
            (not($brand.each = $brand.next.each) and string-length($brand.next.each) &gt; 0) or (string-length($brand.previous.each) &lt; 0) or ($position != last())
             -->
        </xsl:for-each>
    </xsl:template>

    <xsl:template match='/data/module-catalog-category/entry/privyazka-k-tovaru' mode="new-arrivals">
        <xsl:variable name="currPosition" select="position()" />
        <xsl:variable name="category.handle" select="../category/@handle" />
        <xsl:variable name="category.id" select="../@id" />
        <xsl:if test="$currPosition &lt; 5">
            <div class="good">
                <figure>
                    <a href="catalog/{concat($category.handle, '--', $category.id)}/{concat(item/zagolovok/@handle, '--', item/@id)}">
                        <xsl:call-template name="img">
                            <xsl:with-param name="upload" select="item/izobrazhenie"/>
                            <xsl:with-param name="w" select="155"/>
                            <xsl:with-param name="h" select="150"/>
                            <xsl:with-param name="class" select="'img'"/>
                        </xsl:call-template>
                    </a>
                </figure>
                <a href="catalog/{concat($category.handle, '--', $category.id)}/{concat(item/zagolovok/@handle, '--', item/@id)}">
                    <p>
                        <xsl:value-of select="item/kategoriya-tovara" /></p>
                    <xsl:choose>
                        <xsl:when test="string-length(item/strana-proishozhdeniya) &gt; 0">
                            <xsl:if test="string-length(item/brend) &gt; 0">
                                <p><xsl:value-of select="concat(item/brend, ', ', item/strana-proishozhdeniya)" /></p>
                            </xsl:if>
                            <xsl:if test="not(string-length(item/brend) &gt; 0)">
                                <p><xsl:value-of select="concat('бренд не указан', ', ', item/strana-proishozhdeniya)" /></p>
                            </xsl:if>
                        </xsl:when>
                        <xsl:when test="string-length(item/gorod) &gt; 0">
                            <xsl:if test="string-length(item/brend) &gt; 0">
                                <p><xsl:value-of select="concat(item/brend, ', ', item/gorod)" /></p>
                            </xsl:if>
                            <xsl:if test="not(string-length(item/brend) &gt; 0)">
                                <p><xsl:value-of select="concat('бренд не указан', ', ', item/gorod)" /></p>
                            </xsl:if>
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:if test="string-length(item/brend) &gt; 0">
                                <p><xsl:value-of select="concat(item/brend, ', ', ' место происхождения не указано')" /></p>
                            </xsl:if>
                            <xsl:if test="not(string-length(item/brend) &gt; 0)">
                                <p><xsl:value-of select="concat('бренд не указан', ', ', ' место происхождения не указано')" /></p>
                            </xsl:if>
                        </xsl:otherwise>
                    </xsl:choose>

                    <p class="price">
                        <xsl:value-of select="format-number(item/tsena, '### ###', 'rur')" />
                        <span class="rur">a</span>
                    </p>
                </a>
            </div>
        </xsl:if>

    </xsl:template>

    <!-- Блок: Complete price list -->
    <xsl:template match="/data/block-complete-price-list/entry">
        <xsl:call-template name="img">
            <xsl:with-param name="upload" select="ikonka"/>
            <xsl:with-param name="w" select="55"/>
            <xsl:with-param name="h" select="62"/>
            <xsl:with-param name="class" select="'img'"/>
        </xsl:call-template>
        <a href="{$workspace}/uploads/{put-k-prajsu/filename}">
            <xsl:value-of select="zagolovok" />
        </a>
    </xsl:template>

    <xsl:template match="/data/block-footer/entry/menyu/item">
        <div id="{ssylka}">
            <xsl:value-of select="soderzhimoe-slajda[@mode = 'formatted']" disable-output-escaping="yes" />
        </div>
    </xsl:template>

    <!-- Товар на главной -->
    <xsl:template match="/data/block-tovar-na-glavnoy">
        <xsl:apply-templates select="entry" />
    </xsl:template>

    <xsl:template match="/data/block-tovar-na-glavnoy/entry">
        <div class="promo">
            <xsl:call-template name="img">
                <xsl:with-param name="upload" select="izobrazhenie"/>
                <xsl:with-param name="w" select="400"/>
                <xsl:with-param name="h" select="400"/>
                <xsl:with-param name="class" select="'img'"/>
            </xsl:call-template>
            <a>
                <xsl:value-of select="tsena" />
                <span class="rur">a</span><span class="asterisk">*</span>
            </a>
            <p class="notice">*цена может измениться, для уточнения свяжитесь с менеджером.</p>
        </div>
        <div class="opisanie">
            <xsl:value-of select="detalnoe-opisanie[@mode='formatted']" disable-output-escaping="yes" />
        </div>
    </xsl:template>

    <!-- Форма на главной -->
    <xsl:template match="/data/block-form">
        <xsl:apply-templates select="entry" />
    </xsl:template>

    <xsl:template match="/data/block-form/entry">
        <form method="post" action="" enctype="multipart/form-data" id="place-order">
            <fieldset>
                <h1 class="row">Подать заявку</h1>
                <input name="MAX_FILE_SIZE" type="hidden" value="5242880" />
                <p class="row radio">
                    <label><input name="fields[tip]" type="radio" value="На покупку оборудования" checked="checked" />На покупку оборудования</label>
                </p>
                <p class="row radio">
                    <label><input name="fields[tip]" type="radio" value="На сервисное обслуживание" />На сервисное обслуживание</label>
                </p>
                <p class="row input text">
                    <input name="fields[vashe-imya]" type="text" placeholder="Ваше имя*" class="required text" maxlength="60" minlength="2" id="Name"  />
                </p>
                <p class="row input text">
                    <input name="fields[vash-telefon]" type="text" placeholder="Ваш телефон" class="phone" minlength="6" maxlength="12" />
                </p>
                <p class="row input text">
                    <input name="fields[vasha-elektronnaya-pochta]" type="text" placeholder="Ваша электронная почта*" class="required email" id="Email"/>
                </p>
                <p class="row input text">
                    <textarea name="fields[tekst-soobscheniya]" placeholder="Текст сообщения" minlength="2"></textarea>
                </p>
                <input name="send-email[subject]" value="Вы оставили заявку на сайте mera72.ru" type="hidden" />
                <input name="send-email[body]" value="fields[tekst-soobscheniya]" type="hidden" />
                <input name="send-email[recipient]" value="admin" type="hidden" />
                <input name="redirect" type="hidden" value="http://test.mera72.ru/success/" />
                <p class="submit">
                    <input name="action[send-request]" type="submit" value="Отправить" />
                </p>
            </fieldset>
        </form>
    </xsl:template>

    <!-- Блок: Tag Cloud -->

    <xsl:template match="/data/block-tag-cloud/entry/punkty-menyu/item" mode="tag-cloud">
        <xsl:variable name="category.id" select="./@id" />
        <xsl:variable name="page.category" select="category/@handle" />
        <li>
            <a href="catalog/{concat($page.category, '--', $category.id)}">
                <xsl:value-of select="category"/>
            </a>
        </li>
    </xsl:template>

    <!-- Block Contacts -->
    <xsl:template match="/data/block-contacts/entry">
        <h1>
            <xsl:value-of select="'Контакты'" />
        </h1>
        <div class="contacts-item">
            <xsl:apply-templates select="kontakty/item" />
        </div>

        <!-- <script src="http://api-maps.yandex.ru/1.1/?key={$apikey}" type="text/javascript"></script> -->
    </xsl:template>

    <xsl:decimal-format grouping-separator="" decimal-separator="." name="yamap"/>

    <xsl:template match="/data/block-contacts/entry/kontakty/item">
        <div class="item">
            <figure>
                <xsl:call-template name="img">
                    <xsl:with-param name="upload" select="izobrazhenie"/>
                    <xsl:with-param name="w" select="185"/>
                    <xsl:with-param name="h" select="140"/>
                    <xsl:with-param name="class" select="'img'"/>
                </xsl:call-template>
            </figure>
            <div class="text">
                <p class="heading">
                    <xsl:value-of select="zagolovok" />
                </p>
                <p class="opisanie">
                    <xsl:value-of select="opisanie[@mode='formatted']" disable-output-escaping="yes" />
                </p>
            </div>
            <div class="block-contacts-ya-map" id="ya-map-{./@id}"></div>
            <script src="http://api-maps.yandex.ru/1.1/index.xml?key=AI-Yek8BAAAAMWxcNQMAUu3YAu5GwW0Zp7BTWw95FrNPY-wAAAAAAAAAAAC9MSYndqqr8dVBcFFaR8Ju0fSW5Q=="
                    type="text/javascript"></script>
            <script type="text/javascript">
                function createObject (type, point, style, description) {
                var allowObjects = ["Placemark", "Polyline", "Polygon"],
                index = YMaps.jQuery.inArray( type, allowObjects),
                constructor = allowObjects[(index == -1) ? 0 : index];
                description = description || "";
                var object = new YMaps[constructor](point, {style: style, hasBalloon : !!description});
                object.description = description;
                return object;
                }
            </script>
            <script type="text/javascript">
                var map<xsl:value-of select="./@id"/> = new YMaps.Map(YMaps.jQuery("#ya-map-<xsl:value-of
                    select="./@id"/>")[0]);
                map<xsl:value-of select="./@id"/>.setCenter(new YMaps.GeoPoint( <xsl:value-of
                    select="format-number(karta-proezda/@longitude,'#.#################', 'yamap')"/>,<xsl:value-of
                    select="format-number(karta-proezda/@latitude,'#.#########################', 'yamap')"/>),
                <xsl:value-of select="karta-proezda/map/@zoom"/>, YMaps.MapType.MAP);
                map<xsl:value-of select="@id"/>.addControl(new YMaps.Zoom());
                map<xsl:value-of select="@id"/>.addControl(new YMaps.ToolBar());
                //YMaps.MapType.PMAP.getName = function () { return "Народная"; };
                map<xsl:value-of select="@id"/>.addControl(new YMaps.TypeControl([
                YMaps.MapType.MAP,
                YMaps.MapType.SATELLITE,
                YMaps.MapType.HYBRID,
                YMaps.MapType.PMAP
                ], [0, 1, 2, 3]));

                YMaps.Styles.add("constructor#pmlblPlacemark<xsl:value-of select="./@id"/>", {
                iconStyle : {
                href : "http://api-maps.yandex.ru/i/0.3/placemarks/pmlbl.png",
                size : new YMaps.Point(36,41),
                offset: new YMaps.Point(-13,-40)
                }
                });
                var baloon<xsl:value-of select="@id"/> = createObject("Placemark", new YMaps.GeoPoint( <xsl:value-of
                    select="format-number(karta-proezda/@longitude,'#.#################', 'yamap')"/>,<xsl:value-of
                    select="format-number(karta-proezda/@latitude,'#.#########################', 'yamap')"/>),
                "constructor#pmlblPlacemark", "<xsl:value-of select="karta-proezda/@address"/>");
                map<xsl:value-of select="@id"/>.addOverlay(baloon<xsl:value-of select="./@id"/>);
                baloon<xsl:value-of select="@id"/>.openBalloon();
            </script>
        </div>
    </xsl:template>

    <!-- Блок: News -->
    <xsl:template match="/data/block-news/entry">
        <div class="wrapper container">
            <xsl:choose>
                <xsl:when test="$link = 'news' and string-length($category) = 0">
                    <div class="news-wrapper">
                        <h1>
                            <xsl:value-of select="zagolovok" />
                        </h1>
                        <ul>
                            <xsl:apply-templates select="novosti/item" mode="newslist" />
                        </ul>
                    </div>
                </xsl:when>
                <xsl:when test="$link = 'news' and string-length($category) &gt; 0">
                    <xsl:variable name="news.id" select="substring-after($category, '--')" />
                    <div class="news-wrapper">
                        <xsl:apply-templates select="novosti/item[@id = $news.id]" mode="newsdetail" />
                    </div>
                </xsl:when>
            </xsl:choose>
        </div>
    </xsl:template>

    <!-- Шаблон детальной новости -->
    <xsl:template match="/data/block-news/entry/novosti/item" mode="newsdetail">
        <xsl:variable name="trimAfter" select="'150'" />
        <h1>
            <xsl:value-of select="zagolovok" />
        </h1>

        <div class="news-detail">
            <figure>
                <xsl:call-template name="img">
                    <xsl:with-param name="upload" select="izobrazhenie"/>
                    <xsl:with-param name="w" select="165"/>
                    <xsl:with-param name="class" select="'img'"/>
                </xsl:call-template>
            </figure>
            <p class="description">
                <xsl:value-of select="opisanie[@mode='formatted']" disable-output-escaping="yes"/>
            </p>
        </div>
    </xsl:template>

    <!-- Шаблон списка новостей -->
    <xsl:template match="/data/block-news/entry/novosti/item" mode="newslist">
        <xsl:variable name="trimAfter" select="'150'" />
        <li class="news-item">
            <a href="/page/news/{concat('news-item--', ./@id)}" class="link">
                <xsl:value-of select="zagolovok" />
            </a>
            <p>
                <xsl:choose>
                    <xsl:when test="string-length(opisanie[@mode='formatted']) &gt; $trimAfter">
                        <xsl:value-of select="substring(opisanie[@mode='formatted'], 1, $trimAfter)" disable-output-escaping="yes" /><xsl:text>...</xsl:text>
                    </xsl:when>
                </xsl:choose>
            </p>
            <a href="/page/news/{concat('news-item--', ./@id)}" class="podrobnee">подробнее</a>
            <p class="data-publikacii">
                <xsl:value-of select="data-publikatsii" />
            </p>
        </li>
    </xsl:template>

    <!-- Блок: Article -->
    <xsl:template match="/data/block-article/entry">
        <div class="article-wrapper">
            <h1>
                <xsl:value-of select="zagolovok" />
            </h1>
            <xsl:value-of select="opisanie[@mode='formatted']" disable-output-escaping="yes" />
        </div>
    </xsl:template>

    <!-- Блок: Place an Order -->
    <xsl:template match="/data/block-place-an-order/entry">
        <div class="article-wrapper">
            <h1>
                <xsl:value-of select="zagolovok" />
            </h1>
            <form method="post" action="" enctype="multipart/form-data" id="place-order">
                <fieldset>
                    <input name="MAX_FILE_SIZE" type="hidden" value="5242880" />
                    <p class="row required">
                        <label class="text">Ваше имя</label>
                        <input name="fields[vashe-imya]" type="text" class="required" minlength="2" maxlength="60" />
                    </p>
                    <p class="row">
                        <label class="text">Название организации</label>
                        <input name="fields[nazvanie-organizatsii]" type="text" minlength="2" />
                    </p>
                    <p class="row required">
                        <label class="text">Ваш телефон</label>
                        <input name="fields[vash-telefon]" type="text" class="phone required" minlength="6" maxlength="12"/>
                    </p>
                    <p class="row">
                        <label class="text">Ваша электронная почта</label>
                        <input name="fields[vasha-elektronnaya-pochta]" type="text" id="email" class="email required" minlength="2" />
                    </p>
                    <p class="row">
                        <label class="text"></label>
                        <input name="fields[duplicate-email]" type="text" equalTo="#email" class="email" placeholder="введите адрес почты еще раз" minlength="2"/>
                    </p>
                    <p class="row radio">
                        <label class="text"></label>
                        <input type="radio" value="Заявка на покупку оборудования" name="fields[tip]" checked="checked" />
                        <label class="radio" for="fields[tip]">Заявка на покупку оборудования</label>
                    </p>
                    <p class="row radio">
                        <label class="text"></label>
                        <input type="radio" name="fields[tip]" value="Заявка на сервисное обслуживание" />
                        <label class="radio" for="fields[tip]">Заявка на сервисное обслуживание</label>
                    </p>
                    <p class="row radio">
                        <label class="text"></label>
                        <input type="radio" name="fields[tip]" value="Общие вопросы" />
                        <label class="radio" for="fields[tip]">Общие вопросы</label>
                    </p>
                    <p class="row textarea">
                        <label class="text" for="fields[tekst-soobscheniya]">Текст сообщения</label>
                        <textarea name="fields[tekst-soobscheniya]" rows="15" cols="50"></textarea>
                    </p>
                    <p class="row">
                        <label class="text"></label>
                        <input name="action[make-an-order]" type="submit" value="Отправить" />
                    </p>
                    <input name="send-email[subject]" value="Вы оставили заявку на сайте mera72.ru" type="hidden" />
                    <input name="send-email[body]" value="fields[tekst-soobscheniya]" type="hidden" />
                    <input name="send-email[recipient]" value="admin" type="hidden" />
                    <input name="redirect" type="hidden" value="http://test.mera72.ru/success/" />
                </fieldset>
            </form>
        </div>
    </xsl:template>

    <xsl:template match="/data/block-place-an-order/entry/spisok-polej/item">
        <xsl:variable name="field.type" select="tip/item/@handle" />
        <xsl:if test="string-length($field.type) &gt; 0">
            <xsl:choose>
                <xsl:when test="$field.type = 'text'">
                    <xsl:if test="zagolovok/@handle != 'duplicate-email'">
                        <xsl:if test="obyazatelnoe = 'Yes'">
                            <p class="row required">
                                <label class="{$field.type}" for="{zagolovok/@handle}">
                                    <xsl:value-of select="zagolovok" />
                                </label>
                                <input type="{tip/item/@handle}" name="{zagolovok/@handle}" id="{zagolovok/@handle}" class="required" minlength="2" />
                            </p>
                        </xsl:if>
                        <xsl:if test="obyazatelnoe = 'No'">
                            <p class="row">
                                <label class="{$field.type}" for="{zagolovok/@handle}">
                                    <xsl:value-of select="zagolovok" />
                                </label>
                                <input type="{tip/item/@handle}" name="{zagolovok/@handle}" id="{zagolovok/@handle}" />
                            </p>
                        </xsl:if>
                    </xsl:if>
                    <xsl:if test="zagolovok/@handle = 'duplicate-email'" >
                        <p class="row">
                            <label class="{$field.type}" for="{zagolovok/@handle}"><xsl:text> </xsl:text></label>
                            <input type="{tip/item/@handle}" name="{zagolovok/@handle}" id="{zagolovok/@handle}" placeholder="введите адрес почты еще раз" />
                        </p>
                    </xsl:if>
                </xsl:when>
                <xsl:when test="$field.type = 'radio'">
                    <p class="row {$field.type}">
                        <label class="text"><xsl:text> </xsl:text></label>
                        <input type="{$field.type}" name="{zagolovok/@handle}" id="{zagolovok/@handle}" value="{zagolovok/@handle}"  />
                        <label class="{$field.type}" for="{zagolovok/@handle}">
                            <xsl:value-of select="zagolovok" />
                        </label>
                    </p>
                </xsl:when>
                <xsl:when test="$field.type = 'textarea'">
                    <p class="row {$field.type}">
                        <label class="text" for="{zagolovok/@handle}">
                            <xsl:value-of select="zagolovok" />
                        </label>
                        <textarea type="{tip/item/@handle}" name="{zagolovok/@handle}" id="{zagolovok/@handle}"></textarea>
                    </p>
                </xsl:when>
            </xsl:choose>
        </xsl:if>
    </xsl:template>

    <!-- Шаблон страницы успешной отправки формы -->
    <xsl:template match="/data/block-success-message/entry">
        <xsl:value-of select="opisanie[@mode='formatted']" disable-output-escaping="yes" />
    </xsl:template>

</xsl:stylesheet>