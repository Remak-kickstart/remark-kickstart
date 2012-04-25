<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html lang="ru" debug="true">
            <head>
                <meta charset="utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                <base href="{$root}/"/>
                <title>
                    <xsl:value-of select="$page.seo.title" disable-output-escaping="yes"/>
                    <xsl:text> &#8212; </xsl:text>
                    <xsl:value-of select="$website-name"/>
                </title>
                <meta name="keywords" content="{$page.seo.keywords}"/>
                <meta name="description" content="{$page.seo.description}"/>
                <link rel="stylesheet" type="text/css" href="{$workspace}/bootstrap/css/bootstrap.less"/>
                <link rel="stylesheet" type="text/css" href="{$workspace}/css/jquery-ui-1.8.18.custom.css"/>
                <link rel="stylesheet" type="text/css" href="{$workspace}/css/styles.css"/>
                <!-- Here comes the placeholders -->
                <script src="{$workspace}/js/jquery.min.js"></script>
                <script src="{$workspace}/js/jquery.placeholder.min.js"></script>
                <!-- Here comes the validate plugin -->
                <script src="{$workspace}/js/jquery.validate.js"></script>
                <script src="{$workspace}/js/jquery.form.js"></script>
                <!-- Mine.js added fur teh justice -->
                <script src="{$workspace}/js/mine.js"></script>
                
                <!-- Coz that fucking ie doesn't have normal developer tools,
                     this line loading and enabling FirebugLite.
                     Слава роботам! -->
                <xsl:text disable-output-escaping="yes"><![CDATA[<!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->]]></xsl:text>
            </head>
            <body>
                <div class="content-wrapper">
                    <div class="wrap">
                        <xsl:for-each select="/data/page/entry/bloki[@items &gt; 0]/item">
                            <xsl:variable name="id" select="./@id"/>
                            <xsl:apply-templates select="/data/page-blocks/entry[@id = $id][tip/item/@handle != 'footer']" />
                        </xsl:for-each>
                    </div>
                </div>
                <div class="clearfix"></div>
                <xsl:apply-templates select="/data/page-blocks/entry[tip/item/@handle = 'footer']" />
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>