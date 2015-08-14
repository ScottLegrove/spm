<!DOCTYPE html>

<html>
<head>
<title>Student Project Manager</title>

	<link rel="icon" type="image/ico" href="/favicon.ico">
	 <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

<style type="text/css">
* {margin:0; padding:0}
html,body {font:10px Verdana,Arial; color:rgb(252,251,255); margin:0; min-height: 100%; 
				background-image: url('img/downloads-bg.jpg') no-repeat; background-size:cover;}
#wrapper {width:825px; margin:50px auto}
.sortable {width:823px; border:1px solid #ccc; border-bottom:none}
.sortable th {padding:4px 6px 6px; background:#444; color:#fff; text-align:left; color:#ccc}
.sortable td {padding:2px 4px 4px; background:#fff; border-bottom:1px solid #ccc}
.sortable .head {background:#444 url(images/sort.gif) 6px center no-repeat; cursor:pointer; padding-left:18px}
.sortable .desc {background:#222 url(images/desc.gif) 6px center no-repeat; cursor:pointer; padding-left:18px}
.sortable .asc {background:#222 url(images/asc.gif) 6px  center no-repeat; cursor:pointer; padding-left:18px}
.sortable .head:hover, .sortable .desc:hover, .sortable .asc:hover {color:#fff}
.sortable .even td {background:#f2f2f2}
.sortable .odd td {background:#fff}
#gradeCalculator{position: absolute; height:100px; width: 250px; left:1000px; 
		border:1px solid black; padding:8px; background-color:rgba(112,115,127,0.4); margin-bottom:25px;}
#theGrade{position:absolute; top:60px; left:20%;}
input[type='submit']{ padding:3px; color:rgb(56,57,54); bacgkground-color:white; border:1px solid black;
							 font-family: 'Montserrat', sans-serif;}
select{border:1px solid black; font-family: 'Montserrat', sans-serif; width:95px; color: rgb(16,76,127);
			padding-left:3px;}
			
#divTop{ border-bottom:2px solid black; margin-bottom:4px; padding:15px; background-color: rgba(112,115,127,0.4);}





</style>
</head>

<body>
<div>
	@yield('content')
</div>
<script type="text/javascript">

var table=function(){
	function sorter(n){
		this.n=n; this.t; this.b; this.r; this.d; this.p; this.w; this.a=[]; this.l=0
	}
	sorter.prototype.init=function(t,f){
		this.t=document.getElementById(t);
		this.b=this.t.getElementsByTagName('tbody')[0];
		this.r=this.b.rows; var l=this.r.length;
		for(var i=0;i<l;i++){
			if(i==0){
				var c=this.r[i].cells; this.w=c.length;
				for(var x=0;x<this.w;x++){
					if(c[x].className!='nosort'){
						c[x].className='head';
						c[x].onclick=new Function(this.n+'.work(this.cellIndex)')
					}
				}
			}else{
				this.a[i-1]={}; this.l++;
			}
		}
		if(f!=null){
			var a=new Function(this.n+'.work('+f+')'); a()
		}
	}
	sorter.prototype.work=function(y){
		this.b=this.t.getElementsByTagName('tbody')[0]; this.r=this.b.rows;
		var x=this.r[0].cells[y],i;
		for(i=0;i<this.l;i++){
			this.a[i].o=i+1; var v=this.r[i+1].cells[y].firstChild;
			this.a[i].value=(v!=null)?v.nodeValue:''
		}
		for(i=0;i<this.w;i++){
			var c=this.r[0].cells[i];
			if(c.className!='nosort'){c.className='head'}
		}
		if(this.p==y){
			this.a.reverse(); x.className=(this.d)?'asc':'desc';
			this.d=(this.d)?false:true
		}else{
			this.p=y; this.a.sort(compare); x.className='asc'; this.d=false
		}
		var n=document.createElement('tbody');
		n.appendChild(this.r[0]);
		for(i=0;i<this.l;i++){
			var r=this.r[this.a[i].o-1].cloneNode(true);
			n.appendChild(r); r.className=(i%2==0)?'even':'odd'
		}
		this.t.replaceChild(n,this.b)
	}
	function compare(f,c){
		f=f.value,c=c.value;
		var i=parseFloat(f.replace(/(\$|\,)/g,'')),n=parseFloat(c.replace(/(\$|\,)/g,''));
		if(!isNaN(i)&&!isNaN(n)){f=i,c=n}
		return (f>c?1:(f<c?-1:0))
	}
	return{sorter:sorter}
}();

var sorter=new table.sorter("sorter");
sorter.init("sorter");
</script>


</body>
</html>