<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:import href="layout.xsl"/>
    <xsl:import href="blocks.xsl"/>
    <xsl:import href="url.xsl"/>
    <xsl:import href="navigation.xsl"/>
    <xsl:import href="jit.xsl"/>
    <xsl:import href="declention.xsl"/>
    <xsl:import href="date-time.xsl"/>

    <xsl:output method="html"
                doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"
                omit-xml-declaration="no"
                encoding="UTF-8"
                indent="yes"/>

    <xsl:variable name="page" select="/data/page/entry"/>

    <xsl:param name="page.seo.title">
        <xsl:choose>
            <xsl:when test="string-length($page/meta-title)&gt; 0">
                <xsl:value-of select="$page/meta-title"/>
            </xsl:when>
            <xsl:when test="string-length($page/zagolovok) &gt; 0">
                <xsl:value-of select="$page/zagolovok"/>
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="$page-title"/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:param>

    <xsl:param name="page.seo.keywords" select="$page/meta-keywords"/>
    <xsl:param name="page.seo.description" select="$page/meta-description"/>
    <xsl:param name="page.class" select="''"/>
    <xsl:param name="page.id" select="$root-page"/>

</xsl:stylesheet>

