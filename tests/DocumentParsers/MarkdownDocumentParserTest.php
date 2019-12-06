<?php

namespace Rareloop\Primer\Test\DataParsers;

use Mockery;
use PHPUnit\Framework\TestCase;
use Rareloop\Primer\Document;
use Rareloop\Primer\DocumentParsers\MarkdownDocumentParser;

class MarkdownDocumentParserTest extends TestCase
{
    /** @test */
    public function can_parse_markdown_from_content()
    {
        $doc = new Document('id', '# Heading 1');

        $parser = new MarkdownDocumentParser();

        $outputDoc = $parser->parse($doc);

        $this->assertSame('<h1>Heading 1</h1>', trim($outputDoc->content()));
    }

    /** @test */
    public function indents_are_not_treated_as_code_blocks()
    {
        $doc = new Document('id', implode([
            '# Heading 1',
            '',
            '    <span>this is not a code block</span>',
            '',
            'Closing paragraph',
        ], "\n"));

        $parser = new MarkdownDocumentParser();

        $outputDoc = $parser->parse($doc);

        $this->assertNotContains('<pre><code>', $outputDoc->content());
        $this->assertNotContains('</code></pre>', $outputDoc->content());
    }
}
