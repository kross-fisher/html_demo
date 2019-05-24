#!/usr/bin/python
import random, time

num2_list = {}
num3_list = {}

random.seed(int(time.time()))

while True:
    a = random.randint(4, 13)
    b = random.randint(3, 17-a)
    num2_list[(a,b)] = True

    if len(num2_list) > 24:
        break

while True:
    a = random.randint(3, 10)
    b = random.randint(2, 13-a)
    c = random.randint(1, 16-a-b)
    num3_list[(a,b,c)] = True

    if len(num3_list) > 24:
        break

print 'Content-Type: text/html'
print ''
print '''<!DOCTYPE html>
<html>
    <head>
        <title>Question Page</title>
        <style type="text/css">
            table {
                display: inline-block;
                border: 1px solid #665544;
                margin: 20px 20px 20px 80px;
                padding: 10px;
            }
            td {
                width: 24px;
                padding: 4px;
                text-align: center;
                font-size: 1.3em;
                border-bottom: 1px dashed #665544;
            }
        </style>
    </head>
    <body>
        <table id="num2_quzz">''',
for (a, b) in num2_list.keys():
    op = '-' if a > b and random.randint(1, 10) < 8 else '+'
    #op = '+'
    #rs = eval('%d %s %d' % (a, op, b))
    print '''
            <tr>
                <td>%d</td>
                <td>%s</td>
                <td>%d</td>
                <td>=</td>
                <td class="rs"></td>
            </tr>''' % (a, op, b),
print '''
        </table>'''

print '''
        <table id="num3_quzz">''',
for (a, b, c) in num3_list.keys():
    op1 = '-' if a >= b and random.randint(1, 10) < 8 else '+'
    op1 = '+'
    rs1 = eval('%d %s %d' % (a, op1, b))
    op2 = '-' if rs1 >= c and random.randint(1, 10) < 8 else '+'
    print '''
            <tr>
                <td>%d</td>
                <td>%s</td>
                <td>%d</td>
                <td>%s</td>
                <td>%d</td>
                <td>=</td>
                <td> </td>
            </tr>''' % (a, op1, b, op2, c),
print '''
        </table>
    </body>
</html>''',
