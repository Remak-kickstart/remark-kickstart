<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <!-- Склонение после числительных -->
    <xsl:template name="declension">
        <!-- Число -->
        <xsl:param name="number" select="number"/>
        <!-- Именительный падеж (изображение) -->
        <xsl:param name="nominative" select="nominative"/>
        <!-- Родительный падеж, единственное число (изображения) -->
        <xsl:param name="genitive_singular" select="genitive_singular"/>
        <!-- Родительный падеж, множественное число (изображений) -->
        <xsl:param name="genitive_plural" select="genitive_plural"/>
        <xsl:variable name="last_digit">
            <xsl:value-of select="$number mod 10"/>
        </xsl:variable>
        <xsl:variable name="last_two_digits">
            <xsl:value-of select="$number mod 100"/>
        </xsl:variable>
        <xsl:choose>
            <xsl:when test="$last_digit = 1 and $last_two_digits != 11">
                <xsl:value-of select="$nominative"/>
            </xsl:when>
            <xsl:when test="$last_digit = 2 and $last_two_digits != 12
          or $last_digit = 3 and $last_two_digits != 13
          or $last_digit = 4 and $last_two_digits != 14">
                <xsl:value-of select="$genitive_singular"/>
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="$genitive_plural"/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
</xsl:stylesheet>