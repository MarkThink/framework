Twig笔记：
===
可用符号 
---
== != < > >= <= + - ~ * / // % ** | [] . .. and or not in is b-and b-or b-xor 部分符号的含义如下:

~：连接两字符串，相当于PHP中的点号

//：整除

**：乘方，相当于PHP中的^

b-and、b-or、b-xor：按位与、按位或、按位异或

-：减法以及去除空白的简写用法，如 {{- 数据 }} => 去除左边的空白、{{ 数据 -}} => 去除右边的空白、{{- 数据 -}} => 去除两边的空白  

变量 
---
可使用{%set 变量名=变量值 %}声明变量，也可写成{% set 变量名 %} 变量值 {%endset%}

PHP中非关联数组被映射成 [元素1,元素2,...]，关联数组则被映射成{键1:值1,键2:值2,...}

数据统一用foo.bar的形式表示，如果bar是形如my-name的名字，则需写成attribute(foo,'my-name')，

下面是Twig对foo.bar的解析顺序：

1. 当成数组的元素foo['bar']
2. 当成对象的属性foo.bar
3. 当成对象的方法foo.bar()
4. 调用对象的get方法foo.getBar()
5. 调用对象的is方法foo.isBar()
6. 以上都没匹配上则返回null

几个内建的全局变量
---
_self：当前模板的引用

_context：当前上下文的引用

_charset：当前字符集设置的引用

测试语句
---
三元运算符。如{{ '' ? 'a' : 'b'}} => 'b'

xxx is yyy

xxx is not yyy

控制结构 
---
{% if aaa %} xxx {% elseif bbb %} yyy {% else %} zzz{% endif %}：判断语句

{% for %}xxx{% endfor %}：迭代变量

{% do %}：没什么其他含义，{% do 1+2 %}等同于{{ 1+2 }}

{% flush %}：刷新输出缓冲，等同于flush

{% include %}：包含模板

{% extends %}：扩展模板

{% embed %}xxx{% endembed %}：包含模板并扩展该模板的内容，相当于include和extends的结合体

{% use %}：包含模板，近似于多重继承

{% from aaa import bbb as ccc %}：从指定模板导入宏并设置别名

{% macro %} xxx {% endmacro %}：定义宏以便多次调用，与定义PHP函数无异

{% sandbox %}{% include xxx %}{% endsandbox %}：对导入的模板指定沙箱模式，只对include语句有效，只在沙箱模式已开启的情况下生效

{% block xxx %}或{% block %} xxx{% endblock %}：定义代码块或覆盖代码块

{% set xxx %}或{% set %} xxx {% endset %}：在模板内定义变量

{% filter %} xxx {% endfilter %}：多行过滤器

{% spaceless %} xxx {% endspaceless %}：去除HTML片段中的空格

{% autoescape %} xxx {% endautoescape %}：将字符串安全地处理成合法的指定数据

{% verbatim %} xxx {% endverbatim %}：阻止模板引擎的编译，是raw的新名字

内建过滤器
---
过滤器用来修饰数据，各过滤器可以用竖线分隔进行链式调用，用括号传递参数,也可以将过滤器当成单独的函数来用,形式如下：

{% filter 过滤器名 %} 待处理的数据 {% endfilter %}

batch：将数组按指定的个数分割成更小的数组，可选的第二个参数用来在元素不够的情况下进行填充。

如{{[1,2,3,4,5]|batch(2,'NoItem')}}=>[[1,2],[3,4],[5,'NoItem']]

date_modify：修改时间，常与date联用。如{{''|date_modify('+3 days')|date('Y-m-d')}}=>将当前时间加3天后显示

default：当所修饰的数据不存在或为空时，提供默认值。如{{''|default('Ruchee')}}=>'Ruchee'

escape：将字符串安全地处理成合法的指定数据，可简写为e，支持多种转换模式，默认模式为html，其他可选模式有html_attr、js、css、url

first：返回数组的第一个元素或字符串的第一个字符。如{{ {a:1,b:2,c:3}|first}}=>1

last：返回数组的最后一个元素或字符串的最后一个字符。如{{ {a:1,b:2,c:3}|last}}=>3

replace：替换一个字符串中的指定内容。如{{'%s1 love %s2'|

replace({'%s1':'Ruchee','%s2':'Vim'}) }}=>'Ruchee love Vim'

raw：让数据在autoescape过滤器里失效

借用自PHP自带函数的过滤器 
---
abs：取绝对值

nl2br：将字符串里的 \n 替换成 <br/>

join：将数组的各个元素按指定分隔符组成字符串

sort：对数组排序

trim：去除字符串首尾的指定字符，默认为空格

date：格式化时间，可处理与strtotime兼容的字符串，或DateTime/DateInterval的实例，可选的第二个参数用于指定时区，如果所修饰的数据为空则默认为当前时间

reverse：反转一个数组或字符串，在array_reverse的基础上增加了对字符串的处理

slice：截取数组或字符串的一部分，在array_slice的基础上增加了对字符串的处理

keys：将数组的全部键名提取成一个数组，等同于 array_keys

merge：合并两数组，近似于 array_merge 。如 {{ 数组1|merge(数组2) }}

length：返回数组元素的个数或字符串的长度，等同于 count 和 strlen 的结合体   capitalize：将字符串的首字母大写，等同于 ucfirst

title：将字符串中每个单词的首字母大写，等同于 ucwords

lower：将字符串所有字母全部变成小写，等同于 strtolower

upper：将字符串所有字母全部变成大写，等同于 strtoupper

split：将字符串分割成数组，等同于 str_split  

striptags：去除字符串中的 HTML/PHP 标记，等同于 strip_tags

url_encode：编码链接字符串，等同于 urlencode

json_encode：编码 JSON 格式，等同于 json_encode

format：格式化一个字符串，近似于 printf

如 {{ 'My name is %s, and I love %s'|format('Ruchee', 'Vim') }} => 'My name is Ruchee, and I love Vim'

number_format：格式化数值，等同于 number_format

convert_encoding：编码转换，第一个参数指定转换后的编码，第二个参数指定转换前的编码，近似于iconv

内建函数 
---
even：是否为偶数

odd：是否为奇数

empty：是否为空

null：是否为 null

defined：是否已定义

sameas：目标变量与指定值是否指向的是内存中的同一个地址，使用形式 if 变量值 is sameas(指定值)

divisibleby：目标数值是否能够被指定值整除，使用形式 if 目标数值 divisibleby(指定值)，其中指定值不能为0

iterable：目标变量是否是数组或者是否可迭代，使用形式 if 变量值 is iterable

attribute：动态获取变量属性值，两种使用形式为attribute(数组,'元素名')和attribute(对象,'方法名',可选参数)

block：重复引用指定代码块，如{{block('title')}}

constant：从字符串或对象取得常量值

cycle：循环显示一个数组的元素，调用形式为cycle(数组,一个循环变量)

date：格式化时间

dump：在开启调试模式的情况下显示详细的变量信息，等同于var_dump

include：包含其他模板文件

parent：在覆盖代码片段时用于引用父片段的内容

random：制造一个随机数

range：返回一个指定区间的数组，可指定步长，Twig使用..作为其简用法，等同于range

template_from_string：根据字符串加载模板