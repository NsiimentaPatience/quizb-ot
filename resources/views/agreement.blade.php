<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <title>QuizBot</title>
    <style>
        .card-body {
            overflow-y: auto;
            max-height: 300px; /* Adjust this height based on your preference */
        }

    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h5> QuizBot User Agreement.</h5>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                <p>Welcome to QuizBot ("www.quizbotapp.com"). By accessing or using QuizBot, you agree to be bound by the terms and conditions of this User Agreement. If you do not agree to these terms, please do not use the Website.</p>
    
    <h6>1. Eligibility</h6>
    <ul>
        <li><strong>1.1. Age Requirement:</strong> You must be at least 13 years old to use this Website. If you are under 18, you must have the consent of your parent or legal guardian to use the Website.</li>
        <li><strong>1.2. Parental Consent:</strong> For users under the age of 18, a parent or legal guardian must review and agree to this Agreement on your behalf.</li>
    </ul>
    
    <h6>2. User Conduct</h6>
    <ul>
        <li><strong>2.1. Compliance:</strong> You agree to comply with all applicable laws and regulations while using the Website.</li>
        <li><strong>2.2. Prohibited Activities:</strong> You agree not to engage in any of the following activities:</li>
        <ul>
            <li>Using the Website for any illegal or unauthorized purpose.</li>
            <li>Interfering with or disrupting the security, integrity, or performance of the Website.</li>
            <li>Attempting to gain unauthorized access to the Website or its related systems.</li>
        </ul>
    </ul>

    <h6>3. Data Collection and Use</h6>
    <ul>
        <li><strong>3.1. Data Collection:</strong> We may collect personal data from users, including but not limited to name, email address, age, and other information relevant to the use of the Website.</li>
        <li><strong>3.2. Parental Consent for Data Collection:</strong> If you are under the age of 13, your parent or legal guardian must provide verifiable consent for the collection of your personal information.</li>
        <li><strong>3.3. Use of Data:</strong> We may use the collected data for various purposes, including but not limited to improving the Website, personalizing user experience, and marketing.</li>
        <li><strong>3.4. Sharing with Third Parties:</strong> We reserve the right to share user data with third parties for marketing and other purposes. By using the Website, you consent to this sharing.</li>
    </ul>
    
    <h6>4. Intellectual Property</h6>
    <ul>
        <li><strong>4.1. Ownership:</strong> All content, trademarks, and other intellectual property on the Website are the property of QuizBot or its licensors.</li>
        <li><strong>4.2. Limited License:</strong> You are granted a limited, non-exclusive, non-transferable license to access and use the Website for personal, non-commercial purposes.</li>
    </ul>

    <h6>5. Limitation of Liability</h6>
    <ul>
        <li><strong>5.1. Disclaimer:</strong> QuizBot is provided "as is" without any warranties, express or implied.</li>
        <li><strong>5.2. Limitation:</strong> In no event shall QuizBot be liable for any direct, indirect, incidental, special, consequential, or punitive damages arising from your use of the Website.</li>
    </ul>

    <h6>6. Indemnification</h6>
    <ul>
        <li><strong>6.1. Indemnity:</strong> You agree to indemnify and hold harmless QuizBot, its affiliates, and their respective officers, directors, employees, and agents from any claims, liabilities, damages, losses, or expenses arising out of your use of the Website or violation of this Agreement.</li>
    </ul>
    
    <h6>7. Modifications</h6>
    <ul>
        <li><strong>7.1. Changes to Agreement:</strong> We reserve the right to modify this Agreement at any time. Any changes will be effective immediately upon posting the revised Agreement on the Website. Your continued use of the Website after the changes have been posted will constitute your acceptance of the revised Agreement.</li>
    </ul>

    <h6>8. Governing Law</h6>
    <ul>
        <li><strong>8.1. Jurisdiction:</strong> This Agreement shall be governed by and construed in accordance with the laws of Uganda, without regard to its conflict of law principles.</li>
    </ul>
    
    <h6>9. Contact Information</h6>
    <ul>
        <li><strong>9.1. Questions:</strong> If you have any questions about this Agreement, please contact us at quizbotappafrica@gmail.com.</li>
    </ul>

    <h6>10. Acknowledgment</h6>
    <p>By using the Website, you acknowledge that you have read, understood, and agreed to be bound by this Agreement.</p>
            </div>
            <div class="card-footer">
                <form action="{{ route('user.agreement.submit') }}" method="POST">
                    @csrf
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="acceptAgreement" onclick="toggleContinueButton()">
                        <label class="form-check-label" for="acceptAgreement">I agree to the terms and conditions</label>
                    </div>
                    <div class="mt-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('login') }}'">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="continueButton" disabled>Continue</button>
                    </div>
                </form>
                
                </form>
            </div>

            </div>
        </div>
    </div>
    
</body>
<script>
    function toggleContinueButton() {
        const continueButton = document.getElementById('continueButton');
        const acceptAgreement = document.getElementById('acceptAgreement');
        continueButton.disabled = !acceptAgreement.checked;
    }
</script>

</html>