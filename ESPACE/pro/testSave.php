<?php
if (isset($_POSt['canvas']))
{
  // Get the data
  $imageData=$_POSt['canvas'];

  // Remove the headers (data:,) part.
  // A real application should use them according to needs such as to check image type
  $filteredData=substr($imageData, strpos($imageData, ",")+1);

  // Need to decode before saving since the data we received is already base64 encoded
  $unencodedData=base64_decode($filteredData);

   echo "unencodedData".$unencodedData;
   echo "testSave";

  // Save file. This example uses a hard coded filename for testing,
  // but a real application can specify filename in POST variable
  $fp = fopen( 'test.png', 'w');
  fwrite( $fp, $unencodedData);
  fclose( $fp );
}
?>
