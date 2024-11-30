<?php
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
   

    public function testGetDocuments_ReturnsAllDocuments()
    {
        $document=new Document();

        $expectedResult = [
            ['id' => 1, 'title' => 'Document 1', 'user_id' => 1],
            ['id' => 2, 'title' => 'Document 2', 'user_id' => 2],
        ];

        $result = $document->get_documents(false);
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetDocumentsById_ReturnsSingleDocument()
    {
        $document=new Document();

        $expectedResult = ['id' => 1, 'title' => 'Document 1', 'user_id' => 1];
       
        $result = $document->get_documents(1);
        $this->assertEquals($expectedResult, $result);
    }


  
    public function testGetTotalDocuments_ReturnsTotalCount()
{
        $document=new Document();
    
    // Now you should have 5 documents in the table
    $expectedTotal = 2; // Set the expected total count

    // Act: Call the method
    $result = $document->getTotalDocuments();

    // Assert: Verify that the result matches the expected total
    $this->assertEquals($expectedTotal, $result);
}
 
/** @test */
public function sum_twoplustwo()  {
    $document=new Document();
    $expectedTotal = 6; // Set the expected total count

    // Act: Call the method
    $result = $document->sum(3,3);

    // Assert: Verify that the result matches the expected total
    $this->assertEquals($expectedTotal, $result);
    
}
}
    

