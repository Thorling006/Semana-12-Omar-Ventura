<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calculadora Premium</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg: #0F172A;
            --calc-bg: rgba(30, 41, 59, 0.85);
            --display-bg: rgba(15, 23, 42, 0.9);
            --btn-bg: rgba(255, 255, 255, 0.05);
            --btn-hover: rgba(255, 255, 255, 0.1);
            --btn-active: rgba(255, 255, 255, 0.15);
            --primary: #6366F1;
            --primary-hover: #4F46E5;
            --text-light: #F8FAFC;
            --text-muted: #94A3B8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text-light);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            background: radial-gradient(circle at center, #1E293B 0%, #0F172A 100%);
        }

        /* Ambient light behind the calculator */
        body::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        .calculator {
            background-color: var(--calc-bg);
            padding: 24px;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255,255,255,0.1);
            border: 1px solid rgba(255, 255, 255, 0.05);
            width: 320px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            z-index: 1;
            animation: popIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes popIn {
            0% { transform: scale(0.9) translateY(20px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }

        .display {
            background-color: var(--display-bg);
            padding: 20px;
            border-radius: 16px;
            margin-bottom: 20px;
            text-align: right;
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.02);
            min-height: 110px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            word-wrap: break-word;
            word-break: break-all;
            transition: all 0.3s ease;
        }

        .previous-operand {
            color: var(--text-muted);
            font-size: 1rem;
            min-height: 1.2rem;
            font-weight: 400;
        }

        .current-operand {
            color: var(--text-light);
            font-size: 2.8rem;
            font-weight: 600;
            margin-top: 5px;
            letter-spacing: -1px;
        }

        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        button {
            border: none;
            background-color: var(--btn-bg);
            color: var(--text-light);
            font-size: 1.3rem;
            font-weight: 600;
            padding: 20px 0;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.05);
        }

        button:hover {
            background-color: var(--btn-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.1);
        }

        button:active {
            background-color: var(--btn-active);
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.02);
        }

        .operator {
            background-color: rgba(99, 102, 241, 0.08);
            color: #818CF8;
        }

        .operator:hover {
            background-color: rgba(99, 102, 241, 0.15);
        }

        .equals {
            background: linear-gradient(135deg, var(--primary), #2218e85a);
            grid-column: span 2;
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        .equals:hover {
            background: linear-gradient(135deg, var(--primary-hover), #6366F1);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5);
        }

        .clear {
            background-color: rgba(239, 68, 68, 0.1);
            color: #FCA5A5;
            grid-column: span 2;
        }
        
        .clear:hover {
            background-color: rgba(239, 68, 68, 0.2);
        }

    </style>
</head>
<body>

    <div class="calculator">
        <div class="display">
            <div class="previous-operand" id="previous"></div>
            <div class="current-operand" id="current">0</div>
        </div>
        <div class="buttons">
            <button class="clear" onclick="clearDisplay()">AC</button>
            <button class="operator" onclick="deleteNumber()">DEL</button>
            <button class="operator" onclick="appendOperator('/')">÷</button>
            
            <button onclick="appendNumber('7')">7</button>
            <button onclick="appendNumber('8')">8</button>
            <button onclick="appendNumber('9')">9</button>
            <button class="operator" onclick="appendOperator('*')">×</button>
            
            <button onclick="appendNumber('4')">4</button>
            <button onclick="appendNumber('5')">5</button>
            <button onclick="appendNumber('6')">6</button>
            <button class="operator" onclick="appendOperator('-')">-</button>
            
            <button onclick="appendNumber('1')">1</button>
            <button onclick="appendNumber('2')">2</button>
            <button onclick="appendNumber('3')">3</button>
            <button class="operator" onclick="appendOperator('+')">+</button>
            
            <button onclick="appendNumber('0')">0</button>
            <button onclick="appendNumber('.')">.</button>
            <button class="equals" onclick="compute()">=</button>
        </div>
    </div>

    <script>
        let currentOperand = '0';
        let previousOperand = '';
        let operation = undefined;

        const currentTextElement = document.getElementById('current');
        const previousTextElement = document.getElementById('previous');

        function formatNumber(number) {
            if (number === 'Error') return number;
            const stringNumber = number.toString();
            const integerDigits = parseFloat(stringNumber.split('.')[0]);
            const decimalDigits = stringNumber.split('.')[1];
            let integerDisplay;
            
            if (isNaN(integerDigits)) {
                integerDisplay = '';
            } else {
                integerDisplay = integerDigits.toLocaleString('en', { maximumFractionDigits: 0 });
            }
            
            if (decimalDigits != null) {
                return `${integerDisplay}.${decimalDigits}`;
            } else {
                return integerDisplay;
            }
        }

        function updateDisplay() {
            currentTextElement.innerText = formatNumber(currentOperand);
            if (operation != null) {
                let symbol = operation;
                if(symbol === '/') symbol = '÷';
                if(symbol === '*') symbol = '×';
                previousTextElement.innerText = `${formatNumber(previousOperand)} ${symbol}`;
            } else {
                previousTextElement.innerText = '';
            }
        }

        function clearDisplay() {
            currentOperand = '0';
            previousOperand = '';
            operation = undefined;
            updateDisplay();
        }

        function deleteNumber() {
            if (currentOperand === '0') return;
            if (currentOperand === 'Error') {
                clearDisplay();
                return;
            }
            currentOperand = currentOperand.toString().slice(0, -1);
            if (currentOperand === '') currentOperand = '0';
            updateDisplay();
        }

        function appendNumber(number) {
            if (currentOperand === 'Error') clearDisplay();
            
            // Limit digit count
            if (currentOperand.replace('.', '').length >= 10) return;
            
            if (number === '.' && currentOperand.includes('.')) return;
            if (currentOperand === '0' && number !== '.') {
                currentOperand = number.toString();
            } else {
                currentOperand = currentOperand.toString() + number.toString();
            }
            updateDisplay();
        }

        function appendOperator(operator) {
            if (currentOperand === 'Error') clearDisplay();
            if (currentOperand === '0' && previousOperand === '') return;
            if (previousOperand !== '') {
                compute();
            }
            operation = operator;
            previousOperand = currentOperand;
            currentOperand = '0';
            updateDisplay();
        }

        function compute() {
            let computation;
            const prev = parseFloat(previousOperand);
            const current = parseFloat(currentOperand);
            if (isNaN(prev) || isNaN(current)) return;
            
            switch (operation) {
                case '+':
                    computation = prev + current;
                    break;
                case '-':
                    computation = prev - current;
                    break;
                case '*':
                    computation = prev * current;
                    break;
                case '/':
                    if (current === 0) {
                        currentOperand = 'Error';
                        previousOperand = '';
                        operation = undefined;
                        updateDisplay();
                        return;
                    }
                    computation = prev / current;
                    break;
                default:
                    return;
            }
            
            // Limit precision to avoid float issues
            computation = Math.round(computation * 100000000) / 100000000;
            
            // Convert to string to check length
            let compStr = computation.toString();
            if (compStr.replace('.', '').length > 10) {
                compStr = computation.toExponential(4);
            }
            
            currentOperand = compStr;
            operation = undefined;
            previousOperand = '';
            updateDisplay();
        }

        // Add keyboard support
        document.addEventListener('keydown', (e) => {
            if (e.key >= '0' && e.key <= '9' || e.key === '.') {
                appendNumber(e.key);
            }
            if (e.key === '+' || e.key === '-' || e.key === '*' || e.key === '/') {
                appendOperator(e.key);
            }
            if (e.key === 'Enter' || e.key === '=') {
                e.preventDefault();
                compute();
            }
            if (e.key === 'Backspace') {
                deleteNumber();
            }
            if (e.key === 'Escape') {
                clearDisplay();
            }
        });
    </script>
</body>
</html>
