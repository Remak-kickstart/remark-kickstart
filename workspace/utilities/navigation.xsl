<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <!--
        Recursive navigation
        ========================================================================
        Version:	0.3
        Date:		16-04-2011
        Author:		Giel Berkers
        E-mail:		info@gielberkers.com
        Website:	www.gielberkers.com
        ========================================================================
        Makes use of the internal navigation XML structure of Symphony to create
        a recursive navigation.

        Parameters:
            levels:		How many levels deep should this navigation go (default = 999)
            root-url:	What is the root URL (default = blank; equals to $root)

        Usage:

        <xsl:apply-templates select="navigation/page" mode="navigation">
            <xsl:with-param name="levels" select="1" />
        </xsl:apply-templates>

        Special cases:

        If you want to do something special with a link to a specific page, you can override the link-template in your template.
        For example, override the link for the page with handle 'home', you can put this in the template from where you call the navigation-template:

        <xsl:template match="page[@handle = 'home']" mode="link">
            <xsl:param name="root-url" />
            <a href="{$root-url}/{@handle}/" id="home">
                <xsl:value-of select="name"/>
            </a>
        </xsl:template>
    -->
    <xsl:template match="page" mode="navigation">
        <xsl:param name="levels" select="999"/>
        <xsl:param name="sub-level" select="1"/>
        <xsl:param name="root-url" select="$root"/>
        <xsl:if test="not(types/type = 'hidden')">
            <li>
                <!-- Set the class name: -->
                <xsl:choose>
                    <xsl:when test="@id = $current-page-id">
                        <xsl:attribute name="class">active</xsl:attribute>
                    </xsl:when>
                </xsl:choose>
                <!-- Set the link: -->
                <xsl:apply-templates select="." mode="link">
                    <xsl:with-param name="root-url" select="$root-url"/>
                </xsl:apply-templates>
                <!-- Get subpages: -->
                <xsl:if test="$levels &gt; 0 and count(page) &gt; 0">
                    <ul>
                        <xsl:attribute name="class">
                            <xsl:value-of select="concat('sub-', $sub-level)"/>
                        </xsl:attribute>
                        <xsl:apply-templates select="page" mode="navigation">
                            <xsl:with-param name="levels" select="$levels - 1"/>
                            <xsl:with-param name="sub-level" select="$sub-level + 1"/>
                            <xsl:with-param name="root-url" select="concat($root-url, '/', @handle)"/>
                        </xsl:apply-templates>
                    </ul>
                </xsl:if>
            </li>
        </xsl:if>
    </xsl:template>
    <!-- Set the link -->
    <xsl:template match="page" mode="link">
        <xsl:param name="root-url"/>
        <a>
            <xsl:attribute name="href">
                <xsl:value-of select="$root-url"/>
                <xsl:text>/</xsl:text>
                <xsl:value-of select="@handle"/>
                <xsl:text>/</xsl:text>
                <xsl:if test="types/type = 'anchor'">#base</xsl:if>
            </xsl:attribute>
            <xsl:value-of select="name"/>
        </a>
    </xsl:template>
</xsl:stylesheet>