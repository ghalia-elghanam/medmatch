<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E0F7FA;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            direction: ltr; /* Left-to-right layout for English */
        }
        .container {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            gap: 10px;
        }
        .container a {
            text-decoration: none;
            padding: 10px 20px;
            /background-color: #0288D1;/
            color: black;
            border-radius: 5px;
            font-size: 1em;
        }
        .container a:hover {
            /background-color: #0277BD;/
        }
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8em;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #0288D1;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1.2em;
            cursor: pointer;
        }
        button:hover {
            background-color: #0277BD;
        }
        .links {
            margin-top: 20px;
            text-align: center;
        }
        .links a {
            text-decoration: none;
            color: #0288D1;
            margin: 10px;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
        <h2>create new user</h2>
        <form action="{{ url('insertNONF') }}" method="POST">
       
     @csrf
    
        
        <label for="name">name</label>
        <input type="text" id="name" name="name" placeholder="Enter name" required>
        
        <label for="region">region</label>
        <input type="text" id="region" name="region" placeholder="Enter region" required>
        
        
        <div class="text-center mt-3">
            <button class="btn btn-primary" id="voteButton">Vote</button>
        </div>         
        </form>
        <!-- Vote Button -->
           
    </div>
<script>
const contractABI = [
    {
        "inputs": [
            {
                "internalType": "string",
                "name": "_name",
                "type": "string"
            },
            {
                "internalType": "string",
                "name": "_region",
                "type": "string"
            }
        ],
        "name": "addCandidate",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "inputs": [
            {
                "internalType": "string",
                "name": "username",
                "type": "string"
            },
            {
                "internalType": "string",
                "name": "password",
                "type": "string"
            },
            {
                "internalType": "string",
                "name": "qrCode",
                "type": "string"
            },
            {
                "internalType": "string",
                "name": "fingerprint",
                "type": "string"
            }
        ],
        "name": "addUser",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "inputs": [],
        "stateMutability": "nonpayable",
        "type": "constructor"
    },
    {
        "inputs": [
            {
                "internalType": "uint256[]",
                "name": "candidateIDs",
                "type": "uint256[]"
            }
        ],
        "name": "vote",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "inputs": [],
        "name": "candidateCount",
        "outputs": [
            {
                "internalType": "uint256",
                "name": "",
                "type": "uint256"
            }
        ],
        "stateMutability": "view",
        "type": "function"
    },
    {
        "inputs": [
            {
                "internalType": "address",
                "name": "voter",
                "type": "address"
            }
        ],
        "name": "checkHasVoted",
        "outputs": [
            {
                "internalType": "bool",
                "name": "",
                "type": "bool"
            }
        ],
        "stateMutability": "view",
        "type": "function"
    },
    {
        "inputs": [
            {
                "internalType": "uint256",
                "name": "candidateID",
                "type": "uint256"
            }
        ],
        "name": "getCandidate",
        "outputs": [
            {
                "internalType": "uint256",
                "name": "",
                "type": "uint256"
            },
            {
                "internalType": "string",
                "name": "",
                "type": "string"
            },
            {
                "internalType": "string",
                "name": "",
                "type": "string"
            },
            {
                "internalType": "uint256",
                "name": "",
                "type": "uint256"
            }
        ],
        "stateMutability": "view",
        "type": "function"
    },
    {
        "inputs": [],
        "name": "getWinner",
        "outputs": [
            {
                "internalType": "string",
                "name": "winnerName",
                "type": "string"
            },
            {
                "internalType": "uint256",
                "name": "totalVotes",
                "type": "uint256"
            }
        ],
        "stateMutability": "view",
        "type": "function"
    },
    {
        "inputs": [
            {
                "internalType": "string",
                "name": "username",
                "type": "string"
            },
            {
                "internalType": "string",
                "name": "password",
                "type": "string"
            },
            {
                "internalType": "string",
                "name": "qrCode",
                "type": "string"
            },
            {
                "internalType": "string",
                "name": "fingerprint",
                "type": "string"
            }
        ],
        "name": "login",
        "outputs": [
            {
                "internalType": "bool",
                "name": "",
                "type": "bool"
            }
        ],
        "stateMutability": "view",
        "type": "function"
    },
    {
        "inputs": [],
        "name": "owner",
        "outputs": [
            {
                "internalType": "address",
                "name": "",
                "type": "address"
            }
        ],
        "stateMutability": "view",
        "type": "function"
    }
];    // Vote Button Event Listener
const contractAddress2 = "0xC12c7b81c1452bB0D142BdEeFC2Df1fb8BE02962";  // Replace with your deployed contract address
//0xcc8960b26a78beb8e996f404941403d961027c82
// Initialize Web3 provider (MetaMask or Infura)
const web32 = new Web3(window.ethereum);

// Initialize the contract
const contract2 = new web32.eth.Contract(contractABI, contractAddress2);
document.getElementById("voteButton").addEventListener("click", async () => {
    try {

        // Request user accounts from MetaMask (this will prompt MetaMask to open if not connected)
        const accounts = await ethereum.request({ method: 'eth_requestAccounts' });
        if (accounts.length === 0) {
            alert('No accounts found. Please log in to your wallet.');
            return;
        }
        const userAddress = accounts[0];  // Get the first account
        
        const region = document.getElementById('region').value;
        const name = document.getElementById('name').value;
//        
        // Send vote transaction to the smart contract
        await contract2.methods.addCandidate(name,region).send({ from: userAddress });

        alert(Successfully add  !);

        // Optionally refresh the chart or update the UI dynamically
    } catch (error) {
        console.error("Error while voting:", error.message || error);
        alert("Voting failed. Make sure you are connected to the correct network.");
    }
});

</script>
</body>
</html>