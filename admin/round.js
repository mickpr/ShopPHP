function Round2(input)
{
  input=input*100;
  input=Math.round(input);
  input=input/100;
  return input;
}

function ToNetto(input,vat)
{
  output=input/(1+(vat/100));
  output=Round2(output);
  return output;
}

function ToBrutto(input,vat)
{
  output=vat/100;
  output=input*output;
  output=Round2(input)+Round2(output);
  output=Round2(output);
  return output;
}