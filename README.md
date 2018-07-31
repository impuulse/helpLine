Написать мини-веб-сервис на технологии REST-API:

1.       http://service:port/calc/xml
2.       http://service:port/calc/json
 
в качестве данных получает или xml, или json алгебраического выражения и считает его – возвращает число или ошибку. Формат данных можно выбрать самому. Например:

~~~
<expr>
<sum>
  <number>4</number>
  <mul>
     <number>2</number>
     <number>0.5</number>
  </mul>
</sum>
</expr>
~~~

1.       data.json
2.       data.xml
