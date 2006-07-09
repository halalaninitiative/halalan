var _disable_empty_list=false;
var _hide_empty_list=false;
if(typeof (disable_empty_list)=="undefined"){
disable_empty_list=_disable_empty_list;
}
if(typeof (hide_empty_list)=="undefined"){
hide_empty_list=_hide_empty_list;
}
var cs_goodContent=true,cs_M="M",cs_L="L",cs_G="G",cs_EG="EG",cs_curTop=null,cs_curSub=null;
var cs_supportDOM=document.createElement;
var cs_isOpera=(navigator.userAgent.toLowerCase().indexOf("opera")!=-1);
var cc_isMac=(navigator.userAgent.toLowerCase().indexOf("mac")!=-1);
function cs_findOBJ(_1,n){
for(var i=0;i<_1.length;i++){
if(_1[i].name==n){
return _1[i];
}
}
return null;
}
function cs_findContent(n){
return cs_findOBJ(cs_content,n);
}
function cs_findSubContent(n){
return cs_findOBJ(cs_subContent,n);
}
function cs_findM(m,n){
if(m.name==n){
return m;
}
var sm=null;
for(var i=0;i<m.items.length;i++){
if(m.items[i].type==cs_M){
sm=cs_findM(m.items[i],n);
if(sm!=null){
break;
}
}
}
return sm;
}
function cs_findMenu(n){
return (cs_curSub!=null&&cs_curSub.name==n)?cs_curSub:cs_findM(cs_curTop,n);
}
function cs_subContentOBJ(n,_6){
this.name=n;
this.list=_6;
this.ifm=document.createElement("IFRAME");
with(this.ifm.style){
position="absolute";
left="-200px";
top="-200px";
visibility="hidden";
width="100px";
height="100px";
}
document.body.appendChild(this.ifm);
this.ifm.src=n;
}
cs_subContent=new Array();
function cs_contentOBJ(n,_7){
this.name=n;
this.menu=_7;
this.lists=new Array();
this.cookie="";
this.callback=null;
this.count=1;
}
cs_content=new Array();
function cs_topmenuOBJ(tm){
this.name=tm;
this.type=cs_M;
this.items=new Array();
this.df=",";
this.oidx=0;
this.addM=cs_addM;
this.addL=cs_addL;
this.addG=cs_addG,this.endG=cs_endG;
}
function cs_submenuOBJ(_9,_10,sub,_12,css){
this.name=sub;
this.type=cs_M;
this.dis=_9;
this.link=_10;
this.label=_12;
this.css=css;
this.df=",";
this.oidx=0;
var x=cs_findMenu(sub);
this.items=x==null?new Array():x.items;
this.addM=cs_addM;
this.addL=cs_addL;
this.addG=cs_addG,this.endG=cs_endG;
}
function cs_linkOBJ(dis,_16,_17,css){
this.type=cs_L;
this.dis=dis;
this.link=_16;
this.label=_17;
this.css=css;
}
function cs_groupOBJ(_18,css){
this.type=cs_G;
this.dis="";
this.link="";
this.label=_18;
this.css=css;
}
function cs_groupOBJ2(){
this.type=cs_EG;
this.dis="";
this.link="";
this.label="";
}
function cs_addM(dis,_19,sub,_20,css){
this.items[this.items.length]=new cs_submenuOBJ(dis,_19,sub,_20,css);
}
function cs_addL(dis,_21,_22,css){
this.items[this.items.length]=new cs_linkOBJ(dis,_21,_22,css);
}
function cs_addG(_23,css){
this.items[this.items.length]=new cs_groupOBJ(_23,css);
}
function cs_endG(){
this.items[this.items.length]=new cs_groupOBJ2();
}
function cs_showMsg(msg){
window.status=msg;
}
function cs_badContent(n){
cs_goodContent=false;
cs_showMsg("["+n+"] Not Found.");
}
function _setCookie(_25,_26){
document.cookie=_25+"="+_26;
}
function cs_setCookie(_27,_28){
setTimeout("_setCookie('"+_27+"','"+_28+"')",0);
}
function cs_getCookie(_29){
var _30=new RegExp(_29+"=([^;]+)");
if(document.cookie.search(_30)!=-1){
return RegExp.$1;
}else{
return "";
}
}
function cs_optionOBJ(_31,_32,_33,_34,css){
this.type=_31;
this.text=_32;
this.value=_33;
this.label=_34;
this.css=css;
}
function cs_getOptions(_35,_36){
var opt=new Array();
for(var i=0;i<_35.items.length;i++){
opt[i]=new cs_optionOBJ(_35.items[i].type,_35.items[i].dis,_35.items[i].link,_35.items[i].label,_35.items[i].css);
}
if(opt.length==0&&_35.name!=""){
cs_getSubList(_35.name,_36);
}
return opt;
}
function cs_emptyList(_38){
if(cs_supportDOM&&!cc_isMac){
while(_38.lastChild){
_38.removeChild(_38.lastChild);
}
}else{
for(var i=_38.options.length-1;i>=0;i--){
_38.options[i]=null;
}
}
}
function cs_refreshList(_39,opt,df,key){
var l=_39.options.length;
var _43=null,newOpt=null,optCount=0,optPool=_39;
if(cc_isMac){
var l=_39.options.length;
var _44=0;
for(var i=0;i<opt.length;i++){
if(opt[i].type!=cs_G&&opt[i].type!=cs_EG){
_44=l+optCount;
_39.options[_44]=new Option(opt[i].text,opt[i].value,df.indexOf(","+optCount+",")!=-1,df.indexOf(","+optCount+",")!=-1);
_39.options[_44].oidx=optCount;
_39.options[_44].idx=i;
_39.options[_44].key=key;
if(opt[i].label!=""){
_39.options[_44].label=opt[i].label;
}
if(opt[i].css!=""){
_39.options[_44].className=opt[i].css;
}
optCount++;
}
}
return;
}
for(var i=0;i<opt.length;i++){
if(opt[i].type==cs_G){
_43=document.createElement("optgroup");
_43.setAttribute("label",opt[i].label);
if(opt[i].css!=""){
_43.setAttribute("className",opt[i].css);
}
_39.appendChild(_43);
optPool=_43;
}else{
if(opt[i].type==cs_EG){
_43=null;
optPool=_39;
}else{
newOpt=new Option(opt[i].text,opt[i].value);
if(cs_supportDOM){
optPool.appendChild(newOpt);
}else{
_39.options[l+optCount]=newOpt;
}
newOpt.oidx=optCount;
newOpt.idx=i;
newOpt.key=key;
if(!cs_isOpera){
newOpt.text=opt[i].text;
newOpt.value=opt[i].value;
}
if(df.indexOf(","+optCount+",")!=-1){
newOpt.selected=true;
}
if(opt[i].label!=""){
newOpt.label=opt[i].label;
}
if(opt[i].css!=""){
newOpt.className=opt[i].css;
}
optCount++;
}
}
}
}
function cs_getList(_45,key){
var _46=_45.menu;
if(key!="[]"){
var _47=key.substring(1,key.length-1).split(",");
for(var i=0;i<_47.length;i++){
_46=_46.items[parseInt(_47[i],10)];
}
}
return _46;
}
function cs_getKey(key,idx){
return "["+(key=="[]"?"":(key.substring(1,key.length-1)+","))+idx+"]";
}
function cs_getSelected(_49,_50,idx,key,df){
if(_49){
var _51=cs_getCookie(_50+"_"+idx);
if(_51!=""){
var mc=_51.split("-");
for(var i=0;i<mc.length;i++){
if(mc[i].indexOf(key)!=-1){
df=mc[i].substring(key.length);
break;
}
}
}
}
return df;
}
function cs_updateListGroup(_53,idx,_54){
var _55=null,list=_53.lists[idx],options=list.options,has_sublist=false;
var key="",option=",",cookies="";
for(var i=0;i<options.length;i++){
if(options[i].selected){
if(key!=options[i].key){
cookies+=key==""?"":((cookies==""?"":"-")+key+option);
key=options[i].key;
option=",";
_55=cs_getList(_53,key);
}
option+=options[i].oidx+",";
if(idx+1<_53.lists.length){
if(_55.items[options[i].idx].type==cs_M){
if(!has_sublist){
has_sublist=true;
cs_emptyList(_53.lists[idx+1]);
}
var _56=cs_getKey(key,options[i].idx),df=cs_getSelected(_54,_53.cookie,idx+1,_56,_55.items[options[i].idx].df);
cs_refreshList(_53.lists[idx+1],cs_getOptions(_55.items[options[i].idx],list),df,_56);
}
}
}
}
if(key!=""){
cookies+=(cookies==""?"":"-")+key+option;
}
if(_53.cookie){
cs_setCookie(_53.cookie+"_"+idx,cookies);
}
if(has_sublist&&idx+1<_53.lists.length){
if(disable_empty_list){
_53.lists[idx+1].disabled=false;
}
if(hide_empty_list){
_53.lists[idx+1].style.display="";
}
cs_updateListGroup(_53,idx+1,_54);
}else{
for(var s=idx+1;s<_53.lists.length;s++){
cs_emptyList(_53.lists[s]);
if(disable_empty_list){
_53.lists[s].disabled=true;
}
if(hide_empty_list){
_53.lists[s].style.display="none";
}
if(_53.cookie){
cs_setCookie(_53.cookie+"_"+s,"");
}
}
}
}
function cs_initListGroup(_58,_59){
var key="[]",df=cs_getSelected(_59,_58.cookie,0,key,_58.menu.df);
cs_emptyList(_58.lists[0]);
cs_refreshList(_58.lists[0],cs_getOptions(_58.menu,_58.lists[0]),df,key);
cs_updateListGroup(_58,0,_59);
}
function cs_updateList(){
var _60=this.content;
for(var i=0;i<_60.lists.length;i++){
if(_60.lists[i]==this){
cs_updateListGroup(_60,i,_60.cookie);
if(_60.callback){
var opt="";
for(var j=0;j<this.options.length;j++){
if(this.options[j].selected){
if(opt!=""){
opt+=",";
}
if(this.options[j].value!=""){
opt+=this.options[j].value;
}else{
if(this.options[j].text!=""){
opt+=this.options[j].text;
}else{
if(this.options[j].label!=""){
opt+=this.options[j].label;
}
}
}
}
}
_60.callback(this,i+1,_60.count,opt);
}
if(this.handler){
this.handler();
}
break;
}
}
}
function cs_getSubList(n,_62){
if(cs_goodContent&&cs_supportDOM){
var _63=cs_findSubContent(n);
if(_63==null){
cs_subContent[cs_subContent.length]=new cs_subContentOBJ(n,_62);
}
}
}
function cs_updateSubList(cn,sn){
var cc=cs_findContent(cn),sc=cs_findContent(sn);
if(cc!=null&&sc!=null){
var _67=cs_findM(cc.menu,sn);
if(_67!=null){
_67.df=sc.menu.df;
_67.oidx=sc.menu.oidx;
_67.items=sc.menu.items;
}
}
var _68=cs_findSubContent(sn);
if(_68!=null){
_68.list.onchange();
_68.ifm.src="javascript:false;";
document.body.removeChild(_68.ifm);
_68.ifm=null;
}
}
function addListGroup(n,tm){
if(cs_goodContent){
cs_curTop=new cs_topmenuOBJ(tm);
cs_curSub=null;
var c=cs_findContent(n);
if(c==null){
cs_content[cs_content.length]=new cs_contentOBJ(n,cs_curTop);
}else{
delete (c.menu);
c.menu=cs_curTop;
}
}
}
function addList(n,dis,_70,sub,df,_71,css){
if(typeof (sub)=="undefined"||sub==""){
addOption(n,dis,_70||"",df||"",_71||"",css||"");
}else{
if(cs_goodContent){
cs_curSub=cs_findMenu(n);
if(cs_curSub!=null){
cs_curSub.addM(dis,_70||"",sub||"",_71||"",css||"");
if(typeof (df)!="undefined"&&df){
cs_curSub.df+=cs_curSub.oidx+",";
}
cs_curSub.oidx++;
}else{
cs_badContent(n);
}
}
}
}
function addOption(n,dis,_72,df,_73,css){
if(cs_goodContent){
cs_curSub=cs_findMenu(n);
if(cs_curSub!=null){
cs_curSub.addL(dis,_72||"",_73||"",css||"");
if(typeof (df)!="undefined"&&df){
cs_curSub.df+=cs_curSub.oidx+",";
}
cs_curSub.oidx++;
}else{
cs_badContent(n);
}
}
}
function addOptGroup(n,_74,css){
if(cs_goodContent&&!cs_isOpera&&cs_supportDOM){
cs_curSub=cs_findMenu(n);
if(cs_curSub!=null){
cs_curSub.addG(_74,css||"");
}else{
cs_badContent(n);
}
}
}
function endOptGroup(n){
if(cs_goodContent&&!cs_isOpera&&cs_supportDOM){
cs_curSub=cs_findMenu(n);
if(cs_curSub!=null){
cs_curSub.endG();
}else{
cs_badContent(n);
}
}
}
function initListGroup(n){
var _75=cs_findContent(n),count=0;
if(_75!=null){
var _76=new cs_contentOBJ("cs_"+_75.count+"_"+n,_75.menu);
_76.count=_75.count++;
cs_content[cs_content.length]=_76;
for(var i=1;i<initListGroup.arguments.length;i++){
if(typeof (arguments[i])=="object"&&arguments[i].tagName&&arguments[i].tagName=="SELECT"){
_76.lists[count]=arguments[i];
arguments[i].handler=arguments[i].onchange;
arguments[i].onchange=cs_updateList;
arguments[i].content=_76;
arguments[i].idx=count++;
}else{
if(typeof (arguments[i])=="string"&&/^[a-zA-Z_]\w*$/.test(arguments[i])){
_76.cookie=arguments[i];
}else{
if(typeof (arguments[i])=="function"){
_76.callback=arguments[i];
}else{
cs_showMsg("Warning: Unexpected argument in initListGroup() for ["+n+"]");
}
}
}
}
if(_76.lists.length>0){
cs_initListGroup(_76,_76.cookie);
}
}
}
function initListGroups(n){
var _77=0;
for(var i=1;i<initListGroups.arguments.length;i++){
if((typeof (arguments[i])=="object"||typeof (arguments[i])=="function")&&arguments[i].length&&typeof (arguments[i][0])!="undefined"&&arguments[i][0].tagName&&arguments[i][0].tagName=="SELECT"){
if(_77>arguments[i].length||_77==0){
_77=arguments[i].length;
}
}
}
var _78=cs_findContent(n),count=0,content=null;
if(_78!=null){
for(var l=0;l<_77;l++){
count=0;
content=new cs_contentOBJ("cs_"+_78.count+"_"+n,_78.menu);
content.count=_78.count++;
cs_content[cs_content.length]=content;
for(var i=1;i<initListGroups.arguments.length;i++){
if((typeof (arguments[i])=="object"||typeof (arguments[i])=="function")&&arguments[i].length&&typeof (arguments[i][0])!="undefined"&&arguments[i][0].tagName&&arguments[i][0].tagName=="SELECT"){
content.lists[count]=arguments[i][l];
arguments[i][l].handler=arguments[i][l].onchange;
arguments[i][l].onchange=cs_updateList;
arguments[i][l].content=content;
arguments[i][l].idx=count++;
}else{
if(typeof (arguments[i])=="string"&&/^[a-zA-Z_]\w*$/.test(arguments[i])){
content.cookie=arguments[i]+"_"+l;
}else{
if(typeof (arguments[i])=="function"){
content.callback=arguments[i];
}else{
cs_showMsg("Warning: Unexpected argument in initListGroups() for ["+n+"]");
}
}
}
}
if(content.lists.length>0){
cs_initListGroup(content,content.cookie);
}
}
}
}
function resetListGroup(n,_79){
var _80=cs_findContent("cs_"+(_79||1)+"_"+n);
if(_80!=null&&_80.lists.length>0){
cs_initListGroup(_80,"");
}
}
function selectOptions(n,_81,_82){
var _83=cs_findContent(n);
if(_83!=null){
var _84=_81.split(":"),menu=_83.menu,path=true;
for(var i=0;i<_84.length;i+=2){
if(menu.type==cs_M&&path){
path=false;
for(var o=0;o<menu.items.length;o++){
if(_82==0&&menu.items[o].dis==_84[i]||_82==1&&menu.items[o].link==_84[i]||_82==2&&o==_84[i]){
path=true;
if(_84[i+1]!="-"){
menu.df=","+o+",";
}
menu=menu.items[o];
break;
}
}
}
}
}
}

