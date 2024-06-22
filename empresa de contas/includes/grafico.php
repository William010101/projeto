<?php
include_once(__DIR__ . '/../model/conta.php');
include_once(__DIR__ . '/../controller/controller_conta.php');
$result = controller_conta::Ajuste_receita_despesa();
 
$maior_receita = Conta::Maior_receita_despesa_cliente("WHERE contas.tipo_de_conta = 'receita' AND contas.status_pagamento = 'pago'");
$maior_despesa = Conta::Maior_receita_despesa_cliente("WHERE contas.tipo_de_conta = 'despesa_fixa' OR contas.tipo_de_conta = 'despesa_variavel'");
$valorRe = [];
$despesas = [];
foreach($result['receitas'] as $res){
  $valorRe[] = $res['valor'];
}
$valoresReceitas = implode(",", $valorRe);

foreach($result['despesas'] as $resd){
  $despesas[] = $resd['valor'];
}
$despesasV = implode(",", $despesas);

$meses = [
  '01' => 'Jan',
  '02' => 'Feb',
  '03' => 'Mar',
  '04' => 'Apr',
  '05' => 'May',
  '06' => 'Jun',
  '07' => 'Jul',
  '08' => 'Aug',
  '09' => 'Sep',
  '10' => 'Oct',
  '11' => 'Nov',
  '12' => 'Dec',
];

$data = [];

foreach ($result['receitas'] as $resData) {
  $mesAno = explode('-', $resData['mes_ano']);
  if (count($mesAno) == 2) {
      $mes = $mesAno[1];
      if (array_key_exists($mes, $meses)) {
          $data[] = $meses[$mes];
      }
  }
}

// Remove duplicados e reordena os meses no array
$data = array_unique($data);
$ordemMeses = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
usort($data, function($a, $b) use ($ordemMeses) {
  return array_search($a, $ordemMeses) - array_search($b, $ordemMeses);
});

// Envolve cada mês em aspas simples e transforma o array em uma string
$dataF = implode(",", array_map(function($item) {
  return "'$item'";
}, $data));

echo $dataF;
?>

<script src="https://cdn.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js"></script> 
<script src="echarts.js"></script>  

<div id="pizza-receita" style="width: 600px;height:400px;"></div>
<script type="text/javascript">
  var chartDom = document.getElementById('pizza-receita');
var myChart = echarts.init(chartDom);
var option;

option = {
  title: {
    left: 'center',
    text: 'Clientes que mais geraram Receita',
  },
  tooltip: {
    trigger: 'item'
  },
  legend: {
    top: '5%',
    left: 'center'
  },
  series: [
    {
      name: 'Clientes que mais geraram Receita',
      type: 'pie',
      radius: ['40%', '70%'],
      avoidLabelOverlap: false,
      itemStyle: {
        borderRadius: 10,
        borderColor: '#fff',
        borderWidth: 2
      },
      label: {
        show: false,
        position: 'center'
      },
      emphasis: {
        label: {
          show: true,
          fontSize: 40,
          fontWeight: 'bold'
        }
      },
      labelLine: {
        show: false
      },
      data: [
        <?php
        foreach($maior_receita as $res):
        ?>
        { value: <?php echo $res['total_valor']?>, name:<?php echo " '".$res['nome']."' "?>},
        <?php endforeach;?>
      ]
    }
  ]
};

option && myChart.setOption(option);

</script> 
<div id="pizza-despeza" style="width: 600px;height:400px;"></div>
<script type="text/javascript">
  var chartDom = document.getElementById('pizza-despeza');
var myChart = echarts.init(chartDom);
var option;

option = {
  title: {
    left: 'center',
    text: 'Clientes que mais geraram despesa',
  },
  tooltip: {
    trigger: 'item'
  },
  legend: {
    top: '5%',
    left: 'center'
  },
  series: [
    {
      name: 'Clientes que mais geraram Receita',
      type: 'pie',
      radius: ['40%', '70%'],
      avoidLabelOverlap: false,
      itemStyle: {
        borderRadius: 10,
        borderColor: '#fff',
        borderWidth: 2
      },
      label: {
        show: false,
        position: 'center'
      },
      emphasis: {
        label: {
          show: true,
          fontSize: 40,
          fontWeight: 'bold'
        }
      },
      labelLine: {
        show: false
      },
      data: [
        <?php
        foreach($maior_despesa as $res):
        ?>
        { value: <?php echo $res['total_valor']?>, name:<?php echo " '".$res['nome']."' "?>},
        <?php endforeach;?>
      ]
    }
  ]
};

option && myChart.setOption(option);

</script> 


<div id="coluna" style="width: 1500px;height:1000px;"></div>
<script>
var chartDom = document.getElementById('coluna');
var myChart = echarts.init(chartDom);
var option;

option = {
  title: {
    left: 'center',
    text: 'Mapa de Receitas e Despesas',
    subtext: 'Dados Ilustrativos'
  },
  tooltip: {
    trigger: 'axis'
  },
  legend: {
    data: ['Rainfall', 'Evaporation']
  },
  toolbox: {
    show: true,
    feature: {
      dataView: { show: true, readOnly: false },
      magicType: { show: true, type: ['line', 'bar'] },
      restore: { show: true },
      saveAsImage: { show: false }
    }
  },
  calculable: true,
  xAxis: [
    {
      type: 'category',
      <?php echo "data: [" .$dataF . "]";?>,

      // data: [
      //   'Jan',
      //   'Feb',
      //   'Mar',
      //   'Apr',
      //   'May',
      //   'Jun',
      //   'Jul',
      //   'Aug',
      //   'Sep',
      //   'Oct',
      //   'Nov',
      //   'Dec'
      // ]
    }
  ],
  yAxis: [
    {
      type: 'value'
    }
  ],
  series: [
    {
      name: 'Receita',
      type: 'bar',
      itemStyle: {
        normal: {
          color: '#91CC75' // cor azul
        }
      },
      <?php echo "data: [" . $valoresReceitas . "]";?>,
    },
    {
      name: 'Despesas',
      type: 'bar',
      itemStyle: {
        normal: {
          color: '#d69191' // cor verde
        }
      },
      <?php echo "data: [" . $despesasV . "]";?>,
    }
  ]
};

option && myChart.setOption(option);
</script> 