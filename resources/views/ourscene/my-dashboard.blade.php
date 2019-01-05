<?php
	use OurScene\Models\Service;
	use OurScene\Models\User;
	use OurScene\Helpers\DatetimeUtils;
?>


@extends('ourscene.layouts.main')

@section('head')

@endsection

@section('content')
  @include('navs.main-navigation-3',
    ['items' => array(
      array('text' => "COMPS", 'image' => asset('images/icons/blue-combo-chart-24.png'), 'image-active' => asset('images/icons/white-combo-chart-24.png'), 'url' => action('DashboardController@index')),
      array('text' => "PERSONAL", 'image' => asset('images/icons/blue-graph-24.png'), 'image-active' => asset('images/icons/white-graph-24.png'), 'url' => action('DashboardController@getMyState')),
      )
    ]
  )

  <div class="container filter-artist">
    <div class="row">
      <div class="col-md-6">
          <div class="input-field col s12 m8 l4">
            <input type="radio" class="age-allowance" name="age" id="none" value="none"/>
            <label for="none" class="active">None</label>
          </div>
          <div class="input-field col s12 m8 l4">
            <input type="radio" class="age-allowance" name="age" id="18" value="18"/>
            <label for="18" class="active">18+</label>
          </div>
          <div class="input-field col s12 m8 l4">
            <input type="radio" class="age-allowance" name="age" id="21" value="21"/>
            <label for="21" class="active">21+</label>
          </div>
      </div>
      <div class="col-md-6">
          <div class="input-field col s12 m8 l4">
            <input type="radio" name="distance" class="distance" id="5" value="5"/>
            <label for="5" class="active">5 mile</label>
          </div>
          <div class="input-field col s12 m8 l4">
            <input type="radio" name="distance" class="distance" id="10" value="10"/>
            <label for="10" class="active">10 mile</label>
          </div>
          <div class="input-field col s12 m8 l4">
            <input type="radio" name="distance" class="distance" id="15" value="15"/>
            <label for="15" class="active">15 mile</label>
          </div>
      </div>
    </div>
  </div>
	<div id="chart-container">FusionCharts XT will load here!</div>
@endsection

@section('scripts')

<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
<script type="text/javascript">
	var user_name = [];
  	@foreach($books as $book)
		user_name.push ({
			"label": '{{ $book['name'] }}'
		});
	@endforeach
	var confirmed = [];
	@foreach($books as $book)
		confirmed.push ({
			"value": '{{ $book['confirmed'] }}'
		});
	@endforeach

	var pending = [];
	@foreach($books as $book)
		pending.push ({
			"value": '{{ $book['pending'] }}'
		});
	@endforeach

	var rejected = [];
	@foreach($books as $book)
		rejected.push ({
			"value": '{{ $book['rejected'] }}'
		});
	@endforeach
  var curYear = '{{ $curYear }}';

	// console.log(books);
    FusionCharts.ready(function(){

    var fusioncharts = new FusionCharts({
    type: 'scrollstackedcolumn2d',
    dataFormat: 'json',
    renderAt: 'chart-container',
    width: '1200',
    height: '600',
    dataSource: {
        "chart": {
            "theme": "fusion",
            "caption": "Booking Comparison",
            "subCaption": "(" + curYear + ")",
            "xaxisname": "Month",
            "yaxisname": "book",
            "numberprefix": "",
            "lineThickness": "3",
            "flatScrollBars": "1",
            "scrollheight": "10",
            "numVisiblePlot": "12",
            "showHoverEffect": "1",
            "palettecolors":"#2ebf46,ee8f1f,8b0000"
        },
        "categories": [{
            "category": user_name
        }],
        "dataset": [{
            "seriesname": "confirmed",
            "data": confirmed
        }, {
            "seriesname": "pending",
            "data": pending
        }, {
            "seriesname": "next time",
            "data": rejected
        }]
    }
});
    fusioncharts.render();
    });
</script>

<script>
var x, i, j, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
for (i = 0; i < x.length; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < selElmnt.length; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        h = this.parentNode.previousSibling;
        for (i = 0; i < s.length; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            for (k = 0; k < y.length; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  for (i = 0; i < y.length; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);
</script>

@endsection
