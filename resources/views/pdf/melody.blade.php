<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melody Usage and Collaboration License</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend/images/MelodyCollabFinal-favicon.png') }}" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1,
        h2 {
            /* text-align: center; */
        }

        .pdf-wrapper {
            line-height: auto;
            margin-top: 30px;
        }

        .pdf-wrapper h2 {
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: 500;
        }

        .pdf-wrapper p {
            margin-bottom: 5px;
        }

        .signature {
            margin-top: 40px;
        }

        p,
        li {
            margin: 0 0 0 40px;
        }
    </style>
</head>

<body style="padding: 20px">
    <div class="pdf-wrapper">
        <h2><b>Platform:</b> Melody Collab</h2>
        <h2><b>Download Date:</b> {{ date('Y-m-d') }}</h2>
        <h2><b>Downloading Producer’s Name:</b> {{ $producer->name }}</h2>
        <h2><b>Downloading Producer’s Alias:</b> {{ $producer->producer_name }}</h2>
    </div>

    <div class="pdf-wrapper">
        <h2><b>01. Melody Owner</b></h2>
        <p>
            <li><b>Producer Name: </b> {{ $melody->user->name }}</li>
        </p>
        <p>
            <li><b>Sales Platform Alias: </b> {{ $melody->user->producer_name }}</li>
        </p>
    </div>

    <div class="pdf-wrapper">
        <h2><b>02. Melody Information</b></h2>
        <p>
            <li><b>Melody Name: </b> {{ $melody->name }}</li>
        </p>
        <p>
            <li><b>Collaboration Percentage: </b>  {{ $melody->split }}</li>
        </p>
    </div>

    <div class="pdf-wrapper">
        <h2><b>03.Collaboration Terms:</b></h2>
        <p style="padding-left: 18px">
            <li>This license permits any producer to download and use this melody solely for creating
                collaborative beats, in compliance with the terms specified in this license.</li>
        </p>
        <p style="padding-left: 18px">
            <li>
                The producer who downloads this melody agrees to respect the specified earnings
                percentage and to add the melody owner as a collaborator on beat-selling platforms, using the
                provided alias.
            </li>
        </p>
        <p style="padding-left: 18px">
            <li>
                Including the melody owner as a collaborator and respecting the earnings percentage is a
                <b>contractual obligation</b> in any distribution or sale of the beat containing this melody on digital
                stores or beat-selling platforms.
            </li>
        </p>
        <p style="padding-left: 18px">
            <li>
                <b>If the beat becomes part of a musical work and is registered with a Performing Rights
                    Organization (PRO),</b> the downloading producer must contact the melody owner to include them
                as a composer of the work, as applicable.
            </li>
        </p>
    </div>
    <div class="pdf-wrapper">
        <h2><b>04. Intellectual Property</b></h2>
        <p style="padding-left: 18px">
            <li>
                The melody owner retains all copyright and intellectual property rights over the melody.
This license does not grant any additional rights to the melody that are not expressly permitted
within the terms of this collaboration.
            </li>
        </p>
        <p style="padding-left: 18px">
            <li>
                This license is non-transferable and does not grant any sublicensing rights. Producers are
not permitted to share, resell, or redistribute the melody except as part of a beat created under
the terms of this license.
            </li>
        </p>
    </div>

    <div class="pdf-wrapper">
        <h2><b>05. Limitation of Liability</b></h2>
        <p style="padding-left: 18px">
            <li>
                Melody Collab and the melody owner are not responsible for any claims, damages, or losses
that may arise from the use of this melody outside the terms specified in this license.
            </li>
        </p>
        <p style="padding-left: 18px">
            <li>
                The producer who downloads and uses this melody is solely responsible for complying with
the terms of this license and for any consequences arising from non-compliance.
            </li>
        </p>
    </div>
    <div class="pdf-wrapper">
        <h2><b>06. Jurisdiction and Dispute Resolution</b></h2>
        <p style="padding-left: 18px">
            <li>
                This license will be governed and interpreted according to the laws of
                {{ $country }}.
            </li>
        </p>
        <p style="padding-left: 18px">
            <li>
                Any dispute related to this license will be resolved through mediation or arbitration in {{ $country }}, and if unresolved, will be submitted to the competent courts within the same
jurisdiction.
            </li>
        </p>
    </div>
    <div class="pdf-wrapper">
        <h2><b>07. Acceptance of Terms</b></h2>
        <p style="padding-left: 18px">
            <li>
                By downloading this melody, the producer confirms that they understand and accept all
terms specified herein and agree to comply fully.
            </li>
        </p>
        <p style="padding-left: 18px">
            <li>
                Non-compliance with these terms constitutes a legal violation of the melody owner’s rights
                and may result in legal action.
            </li>
        </p>
    </div>
    <div class="pdf-wrapper">
        <h2><b>08. Usage Limitations</b></h2>
        <p style="padding-left: 18px">
            <li>
                This license is valid exclusively for the creation and distribution of a beat containing the
specified melody. It does not grant other rights to the melody or permit its use outside the
collaborative context.
            </li>
        </p>
    </div>

    <hr style="margin-top: 40px">

    <div class="signature">
        <p><strong>Acceptance of Terms:</strong></p>
        <p>By downloading and using the melody, the Collaborating Producer agrees to all terms set forth
            in this license.</p>
    </div>

</body>

</html>
