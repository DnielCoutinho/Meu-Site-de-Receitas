<?php
// header.php já inclui config.php.
include __DIR__ . '/../includes/header.php';
?>

<div class="container">
    <div class="search-header">
        <h1>Resultados da Busca</h1>
        <?php if (isset($_GET['q']) && !empty(trim($_GET['q']))): ?>
            <p class="termo-busca">Você buscou por: <strong>"<?php echo htmlspecialchars(trim($_GET['q'])); ?>"</strong></p>
        <?php endif; ?>
    </div>

    <div class="lista-receitas">
        <?php
        if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
            $query = trim($_GET['q']);
            $receitas_encontradas = [];
            $page = isset($_GET['page']) && ctype_digit($_GET['page']) && (int)$_GET['page']>0 ? (int)$_GET['page'] : 1;
            $limit = 24;
            $offset = ($page-1)*$limit;
            $total = 0; $pages = 0;

            function hl($text, $term){
                $safe = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
                if(!$term) return $safe;
                $pattern = '/' . preg_quote($term,'/') . '/iu';
                return preg_replace($pattern,'<mark class="hl">$0</mark>',$safe);
            }

            if (strpos($query, ',') !== false) { // multi ingredientes
                $ingredientes_busca = array_map('trim', explode(',', strtolower($query)));
                $ingredientes_busca = array_filter(array_unique($ingredientes_busca));
                if ($ingredientes_busca) {
                    $conditions=[]; $params=[]; $types='';
                    foreach($ingredientes_busca as $ing){ $conditions[]='ingredientes LIKE ?'; $params[]='%'.$ing.'%'; $types.='s'; }
                    $where_clause = implode(' OR ', $conditions);
                    // Count total
                    if ($stmtC = $conn->prepare("SELECT COUNT(*) AS total FROM receitas WHERE $where_clause")) {
                        $stmtC->bind_param($types, ...$params); $stmtC->execute(); $rC=$stmtC->get_result(); $total=(int)($rC->fetch_assoc()['total']??0); $stmtC->close();
                    }
                    $pages = $total? (int)ceil($total/$limit) : 0;
                    $sql = "SELECT id, nome, ingredientes, foto FROM receitas WHERE $where_clause LIMIT ? OFFSET ?";
                    if ($stmt = $conn->prepare($sql)) {
                        $bindTypes = $types . 'ii'; $execParams=$params; $execParams[]=$limit; $execParams[]=$offset;
                        $stmt->bind_param($bindTypes, ...$execParams); $stmt->execute(); $res=$stmt->get_result();
                        while($row=$res->fetch_assoc()){
                            $matches=0; $matching=[]; $ingLower=strtolower($row['ingredientes']);
                            foreach($ingredientes_busca as $ib){ if(strpos($ingLower,$ib)!==false){ $matches++; $matching[]=ucfirst($ib);} }
                            $row['matches']=$matches; $row['matching_ingredients']=$matching; $receitas_encontradas[$row['id']]=$row;
                        }
                        $stmt->close();
                    }
                    if ($receitas_encontradas) {
                        uasort($receitas_encontradas, function($a,$b){ return $b['matches'] <=> $a['matches']; });
                    }
                }
            } else { // termo simples
                $pattern="%$query%";
                if ($stmtC = $conn->prepare('SELECT COUNT(*) AS total FROM receitas WHERE nome LIKE ? OR ingredientes LIKE ?')) {
                    $stmtC->bind_param('ss',$pattern,$pattern); $stmtC->execute(); $rC=$stmtC->get_result(); $total=(int)($rC->fetch_assoc()['total']??0); $stmtC->close();
                }
                $pages = $total? (int)ceil($total/$limit):0;
                if ($stmt = $conn->prepare('SELECT id, nome, foto, ingredientes FROM receitas WHERE nome LIKE ? OR ingredientes LIKE ? ORDER BY id DESC LIMIT ? OFFSET ?')) {
                    $stmt->bind_param('ssii',$pattern,$pattern,$limit,$offset); $stmt->execute(); $res=$stmt->get_result();
                    while($row=$res->fetch_assoc()){
                        $matching=[]; $lowerIng=strtolower($row['ingredientes']); $termLower=strtolower($query);
                        foreach(array_slice(array_map('trim', explode(',',$lowerIng)),0,50) as $frag){ if($termLower && strpos($frag,$termLower)!==false){ $matching[]=ucfirst($frag); if(count($matching)>=5) break; } }
                        if($matching){ $row['matches']=count($matching); $row['matching_ingredients']=$matching; }
                        $receitas_encontradas[$row['id']]=$row;
                    }
                    $stmt->close();
                }
            }

            if ($receitas_encontradas) {
                echo "<div class='receitas-grid search-grid'>";
                foreach($receitas_encontradas as $rec){
                    echo "<article class='receita-card'>";
                    echo "<a href='visualizar_receita.php?id={$rec['id']}' style='text-decoration:none;color:inherit;display:flex;flex-direction:column;height:100%;'>";
                    echo "<img src='".get_foto_src($rec['foto'])."' alt='".htmlspecialchars($rec['nome'])."'>";
                    echo "<div class='receita-card-content'>";
                    $isMulti = strpos($query,',')!==false ? '' : $query;
                    echo "<h3>".hl($rec['nome'],$isMulti)."</h3>";
                    if(isset($rec['matches']) && $rec['matches']>0){
                        echo "<div class='match-info'>";
                        echo "<p class='match-count'>Combina com <strong>{$rec['matches']}</strong> dos seus ingredientes:</p>";
                        echo "<div class='match-tags'>";
                        foreach($rec['matching_ingredients'] as $ing){ echo "<span class='tag'>".hl($ing,$isMulti)."</span>"; }
                        echo "</div></div>";
                    }
                    echo "</div></a></article>";
                }
                echo "</div>";
                if ($pages>1){
                    echo "<nav class='pagination' aria-label='Paginação de resultados'><ul>";
                    for($p=1;$p<=$pages;$p++){
                        $active=$p===$page?" class='active'":'';
                        $url='?q='.urlencode($query).'&page='.$p;
                        echo "<li$active><a href='$url' aria-label='Ir para página $p'>$p</a></li>";
                    }
                    echo "</ul></nav>";
                }
            } else {
                echo "<p class='no-results'>Nenhuma receita encontrada para o termo \"".htmlspecialchars($query)."\".</p>";
            }
        } else {
            echo "<p class='no-results'>Por favor, digite um termo para buscar.</p>";
        }
        $conn->close();
        ?>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>