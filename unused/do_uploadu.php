$file_name=StripSlashes($file_name);
$name=$file_name;
$abc=explode(".",$name);

if($abc[1]=="gif")
{
  $gif="1";
}
elseif($abc[1]!="jpg") 
{
  $obrazek="";
  $file_size="0";
}
//sprawdzanie ilo˜ci element¢w tablicy
if(sizeof($abc) > 2)
{
  $obrazek="";
  $file_size="0";
}
elseif(($obrazek!="") && ($file_size!="0"))
{
  //dalszy ci¥g skryptu
}
