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
      data: [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec'
      ]
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