function Uaktualnij(nazwa)
{
  if (nazwa=='upload_miniatura')
    opener.document.frmprodukty.p_miniatura.value = pathPrep(avatar.value);
  else
    opener.document.frmprodukty.p_zdjecie.value = pathPrep(avatar.value);
}
