<?php
require_once('config.php');
// Atualiza as fotos das receitas com imagens relevantes da internet
$imagens = [
    'PIZZA NAPOLITANA' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=750&q=80',
    'ESPAGUETE AO POMODORO' => 'https://images.unsplash.com/photo-1598866594240-a42ea1f4d4d1?auto=format&fit=crop&w=750&q=80',
    'RISOTTO' => 'https://images.unsplash.com/photo-1595908129339-95f14b01ac39?auto=format&fit=crop&w=750&q=80',
    'BISTECCA ALLA FIORENTINA' => 'https://images.unsplash.com/photo-1598515213692-5f282f751880?auto=format&fit=crop&w=750&q=80',
    'FEIJOADA COMPLETA' => 'https://img.freepik.com/fotos-gratis/feijoada-em-uma-tigela-de-ceramica-comida-tradicional-brasileira-em-um-fundo-de-madeira_528335-166.jpg?size=626&ext=jpg',
    'SUSHI (MAKISUSHI)' => 'https://www.shutterstock.com/image-photo/overhead-japanese-sushi-food-maki-ands-2021573107',
    'PAD THAI' => 'https://www.shutterstock.com/image-photo/pad-thai-stirfried-rice-noodles-shrimp-260nw-1433479070.jpg',
    'TACOS AL PASTOR' => 'https://media.istockphoto.com/id/1322282497/photo/delicious-tacos-al-pastor-with-toppings-in-a-traditional-mexican-restaurant.jpg?s=612x612&w=0&k=20&c=3V253wG3gH-C8z_A-3a-5m7d_1s_aQy1f5v0j2cKjYc=',
    'BUTTER CHICKEN (FRANGO NA MANTEIGA)' => 'https://www.gettyimages.com/gi-resources/images/500px/983794168.jpg',
    'WIENER SCHNITZEL' => 'https://images.unsplash.com/photo-1599921841143-819762ae7a1f?auto=format&fit=crop&w=750&q=80',
    'MOUSSAKA' => 'https://www.shutterstock.com/image-photo/moussaka-layer-rich-tomato-beef-600w-1933123999.jpg',
    'GOULASH' => 'https://www.simplyrecipes.com/thmb/k13FFRk_8I0u_yI2d3N2h2iA3aA=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/Simply-Recipes-Goulash-LEAD-04-6985750b6f33433e8771b811521adad6.jpg',
    'PIEROGI' => 'https://media.istockphoto.com/id/1279233632/photo/fried-dumplings-stuffed-with-cabbage-and-meat-sprinkled-with-bacon-greaves-and-chopped.jpg?s=612x612&w=0&k=20&c=pY-03_13y2v_j2J3L3g_O4pr9pS_N32mI3l2Qj5i2yA=',
    'PASTEL DE NATA' => 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=1000&auto=format&fit=crop',
    'FISH AND CHIPS' => 'https://i.ytimg.com/vi/r0iW3p3Z_pA/maxresdefault.jpg',
    'PEKING DUCK' => 'https://i.ytimg.com/vi/5fN5n_5g_2o/maxresdefault.jpg',
    'TANDOORI CHICKEN' => 'https://www.recipetineats.com/wp-content/uploads/2019/05/Tandoori-Chicken_3-1.jpg',
    'RAMEN' => 'https://images.unsplash.com/photo-1591814468924-caf88d1232e1?q=80&w=2070&auto=format&fit=crop',
    'KIMCHI' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d1/Various_kimchi.jpg/767px-Various_kimchi.jpg',
    'POUTINE' => 'https://i.vimeocdn.com/video/1115721912-3225ca53224a8c9f53dd2d934b38323053c63b211a62105895523f013b642a99-d_640x360',
    'GUACAMOLE' => 'https://images.unsplash.com/photo-1534973600-877700000000?auto=format&fit=crop&w=2070&q=80',
    'CEVICHE' => 'https://upload.wikimedia.org/wikipedia/commons/a/a7/Ceviche_de_corvina.jpg',
    'KOSHARI' => 'https://upload.wikimedia.org/wikipedia/commons/4/49/Egyptian_Koshari.jpg',
    'HUMMUS' => 'https://images.unsplash.com/photo-1622279461400-3a3b3b3b3b3b?auto=format&fit=crop&w=750&q=80',
];

foreach ($imagens as $nome => $url) {
    $stmt = $conn->prepare("UPDATE receitas SET foto = ? WHERE nome = ?");
    $stmt->bind_param("ss", $url, $nome);
    $stmt->execute();
    $stmt->close();
}
echo "Fotos atualizadas com sucesso.";
$conn->close();
?>
