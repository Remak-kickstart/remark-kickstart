<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <!--
        Get the URL of a page, according to a given ID.

        Example usage:

        <xsl:call-template name="url">
            <xsl:with-param name="id" select="35" />
        </xsl:call-template>
    -->

    <xsl:template name="url">
        <xsl:param name="id" />
        <xsl:param name="navigation" select="/data/navigation" />

        <xsl:variable name="parent">
            <xsl:call-template name="url-parent">
                <xsl:with-param name="id" select="$id" />
                <xsl:with-param name="navigation" select="$navigation" />
            </xsl:call-template>
        </xsl:variable>

        <xsl:value-of select="concat($root, '/', $parent, $navigation//page[@id = $id]/@handle, '/')" />
    </xsl:template>

    <xsl:template name="url-parent">
        <xsl:param name="id" />
        <xsl:param name="navigation" />

        <xsl:if test="name($navigation//page[@id = $id]/..) = 'page'">
            <xsl:variable name="page" select="$navigation//page[@id = $id]/.." />
            <xsl:variable name="parent">
                <xsl:call-template name="url-parent">
                    <xsl:with-param name="id" select="$page/@id" />
                    <xsl:with-param name="navigation" select="$navigation" />
                </xsl:call-template>
            </xsl:variable>
            <xsl:value-of select="concat($parent, $page/@handle, '/')" />
        </xsl:if>
    </xsl:template>

</xsl:stylesheet>