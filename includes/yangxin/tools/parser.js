var subCount=1,maxNest=1,nestCount=1;
var separator=",";
function parseOption(_1,_2,_3,_4){
return "addOption(\""+_1+"\", \""+_2+"\", \""+_3.replace(/\s+$/,"")+"\""+(_4?", 1":"")+");\n";
}
function parseListOption(_5,_6,_7,_8,_9){
return "addList(\""+_5+"\", \""+_6+"\", \""+_7.replace(/\s+$/,"")+"\", \""+_8+"\""+(_9?", 1":"")+");\n";
}
function parseList(_10,_11,_12,sub,_14,_15){
var _16="",subContent="",sc;
var i=_15.firstChild,item=null;
while(i){
if(i.nodeType==1){
if(i.tagName&&i.tagName=="LI"){
if(item!=null){
_16+=parseOption(sub,item[0],item[1]||item[0],item[2]||0);
}
j=i.firstChild;
item=j.nodeValue.replace(/\s+$/,"").split(separator);
if(i.childNodes.length>1){
for(var x=0;x<i.childNodes.length;x++){
if(i.childNodes[x].tagName&&i.childNodes[x].tagName=="UL"){
nestCount++;
maxNest=Math.max(maxNest,nestCount);
sc=subCount++;
_16+=parseListOption(sub,item[0],item[1]||item[0],"cs-sub-"+sc,item[2]||0);
subContent+="\n"+parseList(sub,item[0],item[1]||item[0],"cs-sub-"+sc,item[2]||0,i.childNodes[x]);
nestCount--;
item=null;
break;
}
}
}
}else{
if(i.tagName&&i.tagName=="UL"){
if(item!=null){
nestCount++;
maxNest=Math.max(maxNest,nestCount);
sc=subCount++;
_16+=parseListOption(sub,item[0],item[1]||item[0],"cs-sub-"+sc,item[2]||0);
subContent+="\n"+parseList(sub,item[0],item[1]||item[0],"cs-sub-"+sc,item[2]||0,i);
nestCount--;
item=null;
}
}
}
}
i=i.nextSibling;
}
if(item!=null){
_16+=parseOption(sub,item[0],item[1]||item[0],item[2]||0);
}
return _16+subContent;
}
function parseTop(_19){
var _20="",subContent="",sc,i=_19.firstChild,item=null;
while(i){
if(i.nodeType==1){
if(i.tagName&&i.tagName=="LI"){
if(item!=null){
_20+=parseOption("cs-top",item[0],item[1]||item[0],item[2]||0);
}
j=i.firstChild;
item=j.nodeValue.replace(/\s+$/,"").split(separator);
if(i.childNodes.length>1){
for(var x=0;x<i.childNodes.length;x++){
if(i.childNodes[x].tagName&&i.childNodes[x].tagName=="UL"){
nestCount++;
maxNest=Math.max(maxNest,nestCount);
sc=subCount++;
_20+=parseListOption("cs-top",item[0],item[1]||item[0],"cs-sub-"+sc,item[2]||0);
subContent+="\n"+parseList("cs-top",item[0],item[1]||item[0],"cs-sub-"+sc,item[2]||0,i.childNodes[x]);
nestCount--;
item=null;
break;
}
}
}
}else{
if(i.tagName&&i.tagName=="UL"){
if(item!=null){
nestCount++;
maxNest=Math.max(maxNest,nestCount);
sc=subCount++;
_20+=parseListOption("cs-top",item[0],item[1]||item[0],"cs-sub-"+sc,item[2]||0);
subContent+="\n"+parseList("cs-top",item[0],item[1]||item[0],"cs-sub-"+sc,item[2]||0,i);
nestCount--;
item=null;
}
}
}
}
i=i.nextSibling;
}
if(item!=null){
_20+=parseOption("cs-top",item[0],item[1]||item[0],item[2]||0);
}
return _20+subContent;
}
function parseGroup(){
var _21="",list=document.getElementById("CS"),listGroup=document.forms[0].listgroup.value;
if(listGroup!=""){
subCount=1;
maxNest=1;
nestCount=1;
_21="addListGroup(\""+listGroup+"\", \"cs-top\");"+"\n\n";
_21+=parseTop(list);
document.forms[0].content.value=_21;
}
}
function showGroup(){
if(document.forms[0].content.value!=""){
demoWin=window.open();
with(demoWin.document){
writeln("<script language=\"javascript\" src=\"../chainedselects.js\"></script>");
writeln("<script language=\"javascript\">");
}
demoWin.document.writeln(document.forms[0].content.value);
demoWin.document.writeln("</script>");
demoWin.document.write("<body onload=\"initListGroup("+"'"+document.forms[0].listgroup.value+"'");
with(demoWin.document){
for(var i=1;i<=maxNest;i++){
write(", document.forms[0].s"+i);
}
writeln(")\">");
writeln("<form>");
for(var i=1;i<=maxNest;i++){
writeln("<p><select style='width:200px;' name=s"+i+"></select></p>");
}
writeln("</form>");
writeln("</body>");
}
demoWin.document.close();
}
}

