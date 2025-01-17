/*
 Highcharts JS v3.0.9 (2014-01-15)

 (c) 2009-2014 Torstein Honsi

 License: www.highcharts.com/license
*/
(function(k,D){function J(a,b,c){this.init.call(this,a,b,c)}var N=k.arrayMin,O=k.arrayMax,t=k.each,z=k.extend,q=k.merge,P=k.map,r=k.pick,w=k.pInt,o=k.getOptions().plotOptions,h=k.seriesTypes,u=k.extendClass,K=k.splat,p=k.wrap,L=k.Axis,A=k.Tick,H=k.Point,Q=k.Pointer,R=k.TrackerMixin,S=k.CenteredSeriesMixin,x=k.Series,v=Math,E=v.round,B=v.floor,T=v.max,U=k.Color,s=function(){};z(J.prototype,{init:function(a,b,c){var d=this,e=d.defaultOptions;d.chart=b;if(b.angular)e.background={};d.options=a=q(e,a);
(a=a.background)&&t([].concat(K(a)).reverse(),function(a){var f=a.backgroundColor,a=q(d.defaultBackgroundOptions,a);if(f)a.backgroundColor=f;a.color=a.backgroundColor;c.options.plotBands.unshift(a)})},defaultOptions:{center:["50%","50%"],size:"85%",startAngle:0},defaultBackgroundOptions:{shape:"circle",borderWidth:1,borderColor:"silver",backgroundColor:{linearGradient:{x1:0,y1:0,x2:0,y2:1},stops:[[0,"#FFF"],[1,"#DDD"]]},from:Number.MIN_VALUE,innerRadius:0,to:Number.MAX_VALUE,outerRadius:"105%"}});
var G=L.prototype,A=A.prototype,V={getOffset:s,redraw:function(){this.isDirty=!1},render:function(){this.isDirty=!1},setScale:s,setCategories:s,setTitle:s},M={isRadial:!0,defaultRadialGaugeOptions:{labels:{align:"center",x:0,y:null},minorGridLineWidth:0,minorTickInterval:"auto",minorTickLength:10,minorTickPosition:"inside",minorTickWidth:1,plotBands:[],tickLength:10,tickPosition:"inside",tickWidth:2,title:{rotation:0},zIndex:2},defaultRadialXOptions:{gridLineWidth:1,labels:{align:null,distance:15,
x:0,y:null},maxPadding:0,minPadding:0,plotBands:[],showLastLabel:!1,tickLength:0},defaultRadialYOptions:{gridLineInterpolation:"circle",labels:{align:"right",x:-3,y:-2},plotBands:[],showLastLabel:!1,title:{x:4,text:null,rotation:90}},setOptions:function(a){this.options=q(this.defaultOptions,this.defaultRadialOptions,a)},getOffset:function(){G.getOffset.call(this);this.chart.axisOffset[this.side]=0;this.center=this.pane.center=S.getCenter.call(this.pane)},getLinePath:function(a,b){var c=this.center,
b=r(b,c[2]/2-this.offset);return this.chart.renderer.symbols.arc(this.left+c[0],this.top+c[1],b,b,{start:this.startAngleRad,end:this.endAngleRad,open:!0,innerR:0})},setAxisTranslation:function(){G.setAxisTranslation.call(this);if(this.center)this.transA=this.isCircular?(this.endAngleRad-this.startAngleRad)/(this.max-this.min||1):this.center[2]/2/(this.max-this.min||1),this.minPixelPadding=this.isXAxis?this.transA*this.minPointOffset+(this.reversed?(this.endAngleRad-this.startAngleRad)/4:0):0},beforeSetTickPositions:function(){this.autoConnect&&
(this.max+=this.categories&&1||this.pointRange||this.closestPointRange||0)},setAxisSize:function(){G.setAxisSize.call(this);if(this.isRadial)this.center=this.pane.center=k.CenteredSeriesMixin.getCenter.call(this.pane),this.len=this.width=this.height=this.isCircular?this.center[2]*(this.endAngleRad-this.startAngleRad)/2:this.center[2]/2},getPosition:function(a,b){if(!this.isCircular)b=this.translate(a),a=this.min;return this.postTranslate(this.translate(a),r(b,this.center[2]/2)-this.offset)},postTranslate:function(a,
b){var c=this.chart,d=this.center,a=this.startAngleRad+a;return{x:c.plotLeft+d[0]+Math.cos(a)*b,y:c.plotTop+d[1]+Math.sin(a)*b}},getPlotBandPath:function(a,b,c){var d=this.center,e=this.startAngleRad,g=d[2]/2,f=[r(c.outerRadius,"100%"),c.innerRadius,r(c.thickness,10)],j=/%$/,n,l=this.isCircular;this.options.gridLineInterpolation==="polygon"?d=this.getPlotLinePath(a).concat(this.getPlotLinePath(b,!0)):(l||(f[0]=this.translate(a),f[1]=this.translate(b)),f=P(f,function(a){j.test(a)&&(a=w(a,10)*g/100);
return a}),c.shape==="circle"||!l?(a=-Math.PI/2,b=Math.PI*1.5,n=!0):(a=e+this.translate(a),b=e+this.translate(b)),d=this.chart.renderer.symbols.arc(this.left+d[0],this.top+d[1],f[0],f[0],{start:a,end:b,innerR:r(f[1],f[0]-f[2]),open:n}));return d},getPlotLinePath:function(a,b){var c=this.center,d=this.chart,e=this.getPosition(a),g,f,j;this.isCircular?j=["M",c[0]+d.plotLeft,c[1]+d.plotTop,"L",e.x,e.y]:this.options.gridLineInterpolation==="circle"?(a=this.translate(a))&&(j=this.getLinePath(0,a)):(g=
d.xAxis[0],j=[],a=this.translate(a),c=g.tickPositions,g.autoConnect&&(c=c.concat([c[0]])),b&&(c=[].concat(c).reverse()),t(c,function(c,b){f=g.getPosition(c,a);j.push(b?"L":"M",f.x,f.y)}));return j},getTitlePosition:function(){var a=this.center,b=this.chart,c=this.options.title;return{x:b.plotLeft+a[0]+(c.x||0),y:b.plotTop+a[1]-{high:0.5,middle:0.25,low:0}[c.align]*a[2]+(c.y||0)}}};p(G,"init",function(a,b,c){var i;var d=b.angular,e=b.polar,g=c.isX,f=d&&g,j,n;n=b.options;var l=c.pane||0;if(d){if(z(this,
f?V:M),j=!g)this.defaultRadialOptions=this.defaultRadialGaugeOptions}else if(e)z(this,M),this.defaultRadialOptions=(j=g)?this.defaultRadialXOptions:q(this.defaultYAxisOptions,this.defaultRadialYOptions);a.call(this,b,c);if(!f&&(d||e)){a=this.options;if(!b.panes)b.panes=[];this.pane=(i=b.panes[l]=b.panes[l]||new J(K(n.pane)[l],b,this),l=i);l=l.options;b.inverted=!1;n.chart.zoomType=null;this.startAngleRad=b=(l.startAngle-90)*Math.PI/180;this.endAngleRad=n=(r(l.endAngle,l.startAngle+360)-90)*Math.PI/
180;this.offset=a.offset||0;if((this.isCircular=j)&&c.max===D&&n-b===2*Math.PI)this.autoConnect=!0}});p(A,"getPosition",function(a,b,c,d,e){var g=this.axis;return g.getPosition?g.getPosition(c):a.call(this,b,c,d,e)});p(A,"getLabelPosition",function(a,b,c,d,e,g,f,j,n){var l=this.axis,i=g.y,m=g.align,y=(l.translate(this.pos)+l.startAngleRad+Math.PI/2)/Math.PI*180%360;l.isRadial?(a=l.getPosition(this.pos,l.center[2]/2+r(g.distance,-25)),g.rotation==="auto"?d.attr({rotation:y}):i===null&&(i=l.chart.renderer.fontMetrics(d.styles.fontSize).b-
d.getBBox().height/2),m===null&&(m=l.isCircular?y>20&&y<160?"left":y>200&&y<340?"right":"center":"center",d.attr({align:m})),a.x+=g.x,a.y+=i):a=a.call(this,b,c,d,e,g,f,j,n);return a});p(A,"getMarkPath",function(a,b,c,d,e,g,f){var j=this.axis;j.isRadial?(a=j.getPosition(this.pos,j.center[2]/2+d),b=["M",b,c,"L",a.x,a.y]):b=a.call(this,b,c,d,e,g,f);return b});o.arearange=q(o.area,{lineWidth:1,marker:null,threshold:null,tooltip:{pointFormat:'<span style="color:{series.color}">{series.name}</span>: <b>{point.low}</b> - <b>{point.high}</b><br/>'},
trackByArea:!0,dataLabels:{verticalAlign:null,xLow:0,xHigh:0,yLow:0,yHigh:0}});h.arearange=u(h.area,{type:"arearange",pointArrayMap:["low","high"],toYData:function(a){return[a.low,a.high]},pointValKey:"low",getSegments:function(){var a=this;t(a.points,function(b){if(!a.options.connectNulls&&(b.low===null||b.high===null))b.y=null;else if(b.low===null&&b.high!==null)b.y=b.high});x.prototype.getSegments.call(this)},translate:function(){var a=this.yAxis;h.area.prototype.translate.apply(this);t(this.points,
function(b){var c=b.low,d=b.high,e=b.plotY;d===null&&c===null?b.y=null:c===null?(b.plotLow=b.plotY=null,b.plotHigh=a.translate(d,0,1,0,1)):d===null?(b.plotLow=e,b.plotHigh=null):(b.plotLow=e,b.plotHigh=a.translate(d,0,1,0,1))})},getSegmentPath:function(a){var b,c=[],d=a.length,e=x.prototype.getSegmentPath,g,f;f=this.options;var j=f.step;for(b=HighchartsAdapter.grep(a,function(a){return a.plotLow!==null});d--;)g=a[d],g.plotHigh!==null&&c.push({plotX:g.plotX,plotY:g.plotHigh});a=e.call(this,b);if(j)j===
!0&&(j="left"),f.step={left:"right",center:"center",right:"left"}[j];c=e.call(this,c);f.step=j;f=[].concat(a,c);c[0]="L";this.areaPath=this.areaPath.concat(a,c);return f},drawDataLabels:function(){var a=this.data,b=a.length,c,d=[],e=x.prototype,g=this.options.dataLabels,f,j=this.chart.inverted;if(g.enabled||this._hasPointLabels){for(c=b;c--;)f=a[c],f.y=f.high,f.plotY=f.plotHigh,d[c]=f.dataLabel,f.dataLabel=f.dataLabelUpper,f.below=!1,j?(g.align="left",g.x=g.xHigh):g.y=g.yHigh;e.drawDataLabels&&e.drawDataLabels.apply(this,
arguments);for(c=b;c--;)f=a[c],f.dataLabelUpper=f.dataLabel,f.dataLabel=d[c],f.y=f.low,f.plotY=f.plotLow,f.below=!0,j?(g.align="right",g.x=g.xLow):g.y=g.yLow;e.drawDataLabels&&e.drawDataLabels.apply(this,arguments)}},alignDataLabel:function(){h.column.prototype.alignDataLabel.apply(this,arguments)},getSymbol:h.column.prototype.getSymbol,drawPoints:s});o.areasplinerange=q(o.arearange);h.areasplinerange=u(h.arearange,{type:"areasplinerange",getPointSpline:h.spline.prototype.getPointSpline});(function(){var a=
h.column.prototype;o.columnrange=q(o.column,o.arearange,{lineWidth:1,pointRange:null});h.columnrange=u(h.arearange,{type:"columnrange",translate:function(){var b=this,c=b.yAxis,d;a.translate.apply(b);t(b.points,function(a){var g=a.shapeArgs,f=b.options.minPointLength,j;a.plotHigh=d=c.translate(a.high,0,1,0,1);a.plotLow=a.plotY;j=d;a=a.plotY-d;a<f&&(f-=a,a+=f,j-=f/2);g.height=a;g.y=j})},trackerGroups:["group","dataLabels"],drawGraph:s,pointAttrToOptions:a.pointAttrToOptions,drawPoints:a.drawPoints,
drawTracker:a.drawTracker,animate:a.animate,getColumnMetrics:a.getColumnMetrics})})();o.gauge=q(o.line,{dataLabels:{enabled:!0,y:15,borderWidth:1,borderColor:"silver",borderRadius:3,crop:!1,style:{fontWeight:"bold"},verticalAlign:"top",zIndex:2},dial:{},pivot:{},tooltip:{headerFormat:""},showInLegend:!1});H={type:"gauge",pointClass:u(H,{setState:function(a){this.state=a}}),angular:!0,drawGraph:s,fixedBox:!0,forceDL:!0,trackerGroups:["group","dataLabels"],translate:function(){var a=this.yAxis,b=this.options,
c=a.center;this.generatePoints();t(this.points,function(d){var e=q(b.dial,d.dial),g=w(r(e.radius,80))*c[2]/200,f=w(r(e.baseLength,70))*g/100,j=w(r(e.rearLength,10))*g/100,n=e.baseWidth||3,l=e.topWidth||1,i=a.startAngleRad+a.translate(d.y,null,null,null,!0);b.wrap===!1&&(i=Math.max(a.startAngleRad,Math.min(a.endAngleRad,i)));i=i*180/Math.PI;d.shapeType="path";d.shapeArgs={d:e.path||["M",-j,-n/2,"L",f,-n/2,g,-l/2,g,l/2,f,n/2,-j,n/2,"z"],translateX:c[0],translateY:c[1],rotation:i};d.plotX=c[0];d.plotY=
c[1]})},drawPoints:function(){var a=this,b=a.yAxis.center,c=a.pivot,d=a.options,e=d.pivot,g=a.chart.renderer;t(a.points,function(f){var c=f.graphic,b=f.shapeArgs,e=b.d,i=q(d.dial,f.dial);c?(c.animate(b),b.d=e):f.graphic=g[f.shapeType](b).attr({stroke:i.borderColor||"none","stroke-width":i.borderWidth||0,fill:i.backgroundColor||"black",rotation:b.rotation}).add(a.group)});c?c.animate({translateX:b[0],translateY:b[1]}):a.pivot=g.circle(0,0,r(e.radius,5)).attr({"stroke-width":e.borderWidth||0,stroke:e.borderColor||
"silver",fill:e.backgroundColor||"black"}).translate(b[0],b[1]).add(a.group)},animate:function(a){var b=this;if(!a)t(b.points,function(a){var d=a.graphic;d&&(d.attr({rotation:b.yAxis.startAngleRad*180/Math.PI}),d.animate({rotation:a.shapeArgs.rotation},b.options.animation))}),b.animate=null},render:function(){this.group=this.plotGroup("group","series",this.visible?"visible":"hidden",this.options.zIndex,this.chart.seriesGroup);x.prototype.render.call(this);this.group.clip(this.chart.clipRect)},setData:function(a,
b){x.prototype.setData.call(this,a,!1);this.processData();this.generatePoints();r(b,!0)&&this.chart.redraw()},drawTracker:R.drawTrackerPoint};h.gauge=u(h.line,H);o.boxplot=q(o.column,{fillColor:"#FFFFFF",lineWidth:1,medianWidth:2,states:{hover:{brightness:-0.3}},threshold:null,tooltip:{pointFormat:'<span style="color:{series.color};font-weight:bold">{series.name}</span><br/>Maximum: {point.high}<br/>Upper quartile: {point.q3}<br/>Median: {point.median}<br/>Lower quartile: {point.q1}<br/>Minimum: {point.low}<br/>'},
whiskerLength:"50%",whiskerWidth:2});h.boxplot=u(h.column,{type:"boxplot",pointArrayMap:["low","q1","median","q3","high"],toYData:function(a){return[a.low,a.q1,a.median,a.q3,a.high]},pointValKey:"high",pointAttrToOptions:{fill:"fillColor",stroke:"color","stroke-width":"lineWidth"},drawDataLabels:s,translate:function(){var a=this.yAxis,b=this.pointArrayMap;h.column.prototype.translate.apply(this);t(this.points,function(c){t(b,function(b){c[b]!==null&&(c[b+"Plot"]=a.translate(c[b],0,1,0,1))})})},drawPoints:function(){var a=
this,b=a.points,c=a.options,d=a.chart.renderer,e,g,f,j,n,l,i,m,y,h,k,I,o,p,q,u,x,s,v,w,A,z,F=a.doQuartiles!==!1,C=parseInt(a.options.whiskerLength,10)/100;t(b,function(b){y=b.graphic;A=b.shapeArgs;k={};p={};u={};z=b.color||a.color;if(b.plotY!==D)if(e=b.pointAttr[b.selected?"selected":""],x=A.width,s=B(A.x),v=s+x,w=E(x/2),g=B(F?b.q1Plot:b.lowPlot),f=B(F?b.q3Plot:b.lowPlot),j=B(b.highPlot),n=B(b.lowPlot),k.stroke=b.stemColor||c.stemColor||z,k["stroke-width"]=r(b.stemWidth,c.stemWidth,c.lineWidth),k.dashstyle=
b.stemDashStyle||c.stemDashStyle,p.stroke=b.whiskerColor||c.whiskerColor||z,p["stroke-width"]=r(b.whiskerWidth,c.whiskerWidth,c.lineWidth),u.stroke=b.medianColor||c.medianColor||z,u["stroke-width"]=r(b.medianWidth,c.medianWidth,c.lineWidth),u["stroke-linecap"]="round",i=k["stroke-width"]%2/2,m=s+w+i,h=["M",m,f,"L",m,j,"M",m,g,"L",m,n,"z"],F&&(i=e["stroke-width"]%2/2,m=B(m)+i,g=B(g)+i,f=B(f)+i,s+=i,v+=i,I=["M",s,f,"L",s,g,"L",v,g,"L",v,f,"L",s,f,"z"]),C&&(i=p["stroke-width"]%2/2,j+=i,n+=i,o=["M",m-
w*C,j,"L",m+w*C,j,"M",m-w*C,n,"L",m+w*C,n]),i=u["stroke-width"]%2/2,l=E(b.medianPlot)+i,q=["M",s,l,"L",v,l,"z"],y)b.stem.animate({d:h}),C&&b.whiskers.animate({d:o}),F&&b.box.animate({d:I}),b.medianShape.animate({d:q});else{b.graphic=y=d.g().add(a.group);b.stem=d.path(h).attr(k).add(y);if(C)b.whiskers=d.path(o).attr(p).add(y);if(F)b.box=d.path(I).attr(e).add(y);b.medianShape=d.path(q).attr(u).add(y)}})}});o.errorbar=q(o.boxplot,{color:"#000000",grouping:!1,linkedTo:":previous",tooltip:{pointFormat:'<span style="color:{series.color}">{series.name}</span>: <b>{point.low}</b> - <b>{point.high}</b><br/>'},
whiskerWidth:null});h.errorbar=u(h.boxplot,{type:"errorbar",pointArrayMap:["low","high"],toYData:function(a){return[a.low,a.high]},pointValKey:"high",doQuartiles:!1,getColumnMetrics:function(){return this.linkedParent&&this.linkedParent.columnMetrics||h.column.prototype.getColumnMetrics.call(this)}});o.waterfall=q(o.column,{lineWidth:1,lineColor:"#333",dashStyle:"dot",borderColor:"#333"});h.waterfall=u(h.column,{type:"waterfall",upColorProp:"fill",pointArrayMap:["low","y"],pointValKey:"y",init:function(a,
b){b.stacking=!0;h.column.prototype.init.call(this,a,b)},translate:function(){var a=this.options,b=this.yAxis,c,d,e,g,f,j,n,l,i;c=a.threshold;a=a.borderWidth%2/2;h.column.prototype.translate.apply(this);l=c;e=this.points;for(d=0,c=e.length;d<c;d++){g=e[d];f=g.shapeArgs;j=this.getStack(d);i=j.points[this.index];if(isNaN(g.y))g.y=this.yData[d];n=T(l,l+g.y)+i[0];f.y=b.translate(n,0,1);g.isSum||g.isIntermediateSum?(f.y=b.translate(i[1],0,1),f.height=b.translate(i[0],0,1)-f.y):l+=j.total;f.height<0&&(f.y+=
f.height,f.height*=-1);g.plotY=f.y=E(f.y)-a;f.height=E(f.height);g.yBottom=f.y+f.height}},processData:function(a){var b=this.yData,c=this.points,d,e=b.length,g=this.options.threshold||0,f,j,n,l,i,m;j=f=n=l=g;for(m=0;m<e;m++)i=b[m],d=c&&c[m]?c[m]:{},i==="sum"||d.isSum?b[m]=j:i==="intermediateSum"||d.isIntermediateSum?(b[m]=f,f=g):(j+=i,f+=i),n=Math.min(j,n),l=Math.max(j,l);x.prototype.processData.call(this,a);this.dataMin=n;this.dataMax=l},toYData:function(a){if(a.isSum)return"sum";else if(a.isIntermediateSum)return"intermediateSum";
return a.y},getAttribs:function(){h.column.prototype.getAttribs.apply(this,arguments);var a=this.options,b=a.states,c=a.upColor||this.color,a=k.Color(c).brighten(0.1).get(),d=q(this.pointAttr),e=this.upColorProp;d[""][e]=c;d.hover[e]=b.hover.upColor||a;d.select[e]=b.select.upColor||c;t(this.points,function(a){if(a.y>0&&!a.color)a.pointAttr=d,a.color=c})},getGraphPath:function(){var a=this.data,b=a.length,c=E(this.options.lineWidth+this.options.borderWidth)%2/2,d=[],e,g,f;for(f=1;f<b;f++)g=a[f].shapeArgs,
e=a[f-1].shapeArgs,g=["M",e.x+e.width,e.y+c,"L",g.x,e.y+c],a[f-1].y<0&&(g[2]+=e.height,g[5]+=e.height),d=d.concat(g);return d},getExtremes:s,getStack:function(a){var b=this.yAxis.stacks,c=this.stackKey;this.processedYData[a]<this.options.threshold&&(c="-"+c);return b[c][a]},drawGraph:x.prototype.drawGraph});o.bubble=q(o.scatter,{dataLabels:{inside:!0,style:{color:"white",textShadow:"0px 0px 3px black"},verticalAlign:"middle"},marker:{lineColor:null,lineWidth:1},minSize:8,maxSize:"20%",tooltip:{pointFormat:"({point.x}, {point.y}), Size: {point.z}"},
turboThreshold:0,zThreshold:0});h.bubble=u(h.scatter,{type:"bubble",pointArrayMap:["y","z"],parallelArrays:["x","y","z"],trackerGroups:["group","dataLabelsGroup"],bubblePadding:!0,pointAttrToOptions:{stroke:"lineColor","stroke-width":"lineWidth",fill:"fillColor"},applyOpacity:function(a){var b=this.options.marker,c=r(b.fillOpacity,0.5),a=a||b.fillColor||this.color;c!==1&&(a=U(a).setOpacity(c).get("rgba"));return a},convertAttribs:function(){var a=x.prototype.convertAttribs.apply(this,arguments);a.fill=
this.applyOpacity(a.fill);return a},getRadii:function(a,b,c,d){var e,g,f,j=this.zData,n=[],l=this.options.sizeBy!=="width";for(g=0,e=j.length;g<e;g++)f=b-a,f=f>0?(j[g]-a)/(b-a):0.5,l&&f>=0&&(f=Math.sqrt(f)),n.push(v.ceil(c+f*(d-c))/2);this.radii=n},animate:function(a){var b=this.options.animation;if(!a)t(this.points,function(a){var d=a.graphic,a=a.shapeArgs;d&&a&&(d.attr("r",1),d.animate({r:a.r},b))}),this.animate=null},translate:function(){var a,b=this.data,c,d,e=this.radii;h.scatter.prototype.translate.call(this);
for(a=b.length;a--;)c=b[a],d=e?e[a]:0,c.negative=c.z<(this.options.zThreshold||0),d>=this.minPxSize/2?(c.shapeType="circle",c.shapeArgs={x:c.plotX,y:c.plotY,r:d},c.dlBox={x:c.plotX-d,y:c.plotY-d,width:2*d,height:2*d}):c.shapeArgs=c.plotY=c.dlBox=D},drawLegendSymbol:function(a,b){var c=w(a.itemStyle.fontSize)/2;b.legendSymbol=this.chart.renderer.circle(c,a.baseline-c,c).attr({zIndex:3}).add(b.legendGroup);b.legendSymbol.isMarker=!0},drawPoints:h.column.prototype.drawPoints,alignDataLabel:h.column.prototype.alignDataLabel});
L.prototype.beforePadding=function(){var a=this,b=this.len,c=this.chart,d=0,e=b,g=this.isXAxis,f=g?"xData":"yData",j=this.min,n={},l=v.min(c.plotWidth,c.plotHeight),i=Number.MAX_VALUE,m=-Number.MAX_VALUE,h=this.max-j,k=b/h,p=[];this.tickPositions&&(t(this.series,function(b){var f=b.options;if(b.bubblePadding&&b.visible&&(a.allowZoomOutside=!0,p.push(b),g))t(["minSize","maxSize"],function(a){var b=f[a],g=/%$/.test(b),b=w(b);n[a]=g?l*b/100:b}),b.minPxSize=n.minSize,b=b.zData,b.length&&(i=v.min(i,v.max(N(b),
f.displayNegative===!1?f.zThreshold:-Number.MAX_VALUE)),m=v.max(m,O(b)))}),t(p,function(a){var b=a[f],c=b.length,l;g&&a.getRadii(i,m,n.minSize,n.maxSize);if(h>0)for(;c--;)typeof b[c]==="number"&&(l=a.radii[c],d=Math.min((b[c]-j)*k-l,d),e=Math.max((b[c]-j)*k+l,e))}),p.length&&h>0&&r(this.options.min,this.userMin)===D&&r(this.options.max,this.userMax)===D&&(e-=b,k*=(b+d-e)/b,this.min+=d/k,this.max+=e/k))};(function(){function a(a,b,c){a.call(this,b,c);if(this.chart.polar)this.closeSegment=function(a){var b=
this.xAxis.center;a.push("L",b[0],b[1])},this.closedStacks=!0}function b(a,b){var c=this.chart,d=this.options.animation,e=this.group,i=this.markerGroup,m=this.xAxis.center,h=c.plotLeft,k=c.plotTop;if(c.polar){if(c.renderer.isSVG)if(d===!0&&(d={}),b){if(c={translateX:m[0]+h,translateY:m[1]+k,scaleX:0.001,scaleY:0.001},e.attr(c),i)i.attrSetters=e.attrSetters,i.attr(c)}else c={translateX:h,translateY:k,scaleX:1,scaleY:1},e.animate(c,d),i&&i.animate(c,d),this.animate=null}else a.call(this,b)}var c=x.prototype,
d=Q.prototype,e;c.toXY=function(a){var b,c=this.chart;b=a.plotX;var d=a.plotY;a.rectPlotX=b;a.rectPlotY=d;a.clientX=(b/Math.PI*180+this.xAxis.pane.options.startAngle)%360;b=this.xAxis.postTranslate(a.plotX,this.yAxis.len-d);a.plotX=a.polarPlotX=b.x-c.plotLeft;a.plotY=a.polarPlotY=b.y-c.plotTop};c.orderTooltipPoints=function(a){if(this.chart.polar&&(a.sort(function(a,b){return a.clientX-b.clientX}),a[0]))a[0].wrappedClientX=a[0].clientX+360,a.push(a[0])};h.area&&p(h.area.prototype,"init",a);h.areaspline&&
p(h.areaspline.prototype,"init",a);h.spline&&p(h.spline.prototype,"getPointSpline",function(a,b,c,d){var e,i,m,h,k,p,o;if(this.chart.polar){e=c.plotX;i=c.plotY;a=b[d-1];m=b[d+1];this.connectEnds&&(a||(a=b[b.length-2]),m||(m=b[1]));if(a&&m)h=a.plotX,k=a.plotY,b=m.plotX,p=m.plotY,h=(1.5*e+h)/2.5,k=(1.5*i+k)/2.5,m=(1.5*e+b)/2.5,o=(1.5*i+p)/2.5,b=Math.sqrt(Math.pow(h-e,2)+Math.pow(k-i,2)),p=Math.sqrt(Math.pow(m-e,2)+Math.pow(o-i,2)),h=Math.atan2(k-i,h-e),k=Math.atan2(o-i,m-e),o=Math.PI/2+(h+k)/2,Math.abs(h-
o)>Math.PI/2&&(o-=Math.PI),h=e+Math.cos(o)*b,k=i+Math.sin(o)*b,m=e+Math.cos(Math.PI+o)*p,o=i+Math.sin(Math.PI+o)*p,c.rightContX=m,c.rightContY=o;d?(c=["C",a.rightContX||a.plotX,a.rightContY||a.plotY,h||e,k||i,e,i],a.rightContX=a.rightContY=null):c=["M",e,i]}else c=a.call(this,b,c,d);return c});p(c,"translate",function(a){a.call(this);if(this.chart.polar&&!this.preventPostTranslate)for(var a=this.points,b=a.length;b--;)this.toXY(a[b])});p(c,"getSegmentPath",function(a,b){var c=this.points;if(this.chart.polar&&
this.options.connectEnds!==!1&&b[b.length-1]===c[c.length-1]&&c[0].y!==null)this.connectEnds=!0,b=[].concat(b,[c[0]]);return a.call(this,b)});p(c,"animate",b);p(c,"setTooltipPoints",function(a,b){this.chart.polar&&z(this.xAxis,{tooltipLen:360});return a.call(this,b)});if(h.column)e=h.column.prototype,p(e,"animate",b),p(e,"translate",function(a){var b=this.xAxis,c=this.yAxis.len,d=b.center,e=b.startAngleRad,i=this.chart.renderer,h,k;this.preventPostTranslate=!0;a.call(this);if(b.isRadial){b=this.points;
for(k=b.length;k--;)h=b[k],a=h.barX+e,h.shapeType="path",h.shapeArgs={d:i.symbols.arc(d[0],d[1],c-h.plotY,null,{start:a,end:a+h.pointWidth,innerR:c-r(h.yBottom,c)})},this.toXY(h)}}),p(e,"alignDataLabel",function(a,b,d,e,h,i){if(this.chart.polar){a=b.rectPlotX/Math.PI*180;if(e.align===null)e.align=a>20&&a<160?"left":a>200&&a<340?"right":"center";if(e.verticalAlign===null)e.verticalAlign=a<45||a>315?"bottom":a>135&&a<225?"top":"middle";c.alignDataLabel.call(this,b,d,e,h,i)}else a.call(this,b,d,e,h,
i)});p(d,"getIndex",function(a,b){var c,d=this.chart,e;d.polar?(e=d.xAxis[0].center,c=b.chartX-e[0]-d.plotLeft,d=b.chartY-e[1]-d.plotTop,c=180-Math.round(Math.atan2(c,d)/Math.PI*180)):c=a.call(this,b);return c});p(d,"getCoordinates",function(a,b){var c=this.chart,d={xAxis:[],yAxis:[]};c.polar?t(c.axes,function(a){var e=a.isXAxis,g=a.center,h=b.chartX-g[0]-c.plotLeft,g=b.chartY-g[1]-c.plotTop;d[e?"xAxis":"yAxis"].push({axis:a,value:a.translate(e?Math.PI-Math.atan2(h,g):Math.sqrt(Math.pow(h,2)+Math.pow(g,
2)),!0)})}):d=a.call(this,b);return d})})()})(Highcharts);