pipeline {
    agent any
    environment {
        SCANNER_HOME = tool 'sonar-scanner' // Ensure 'sonar-scanner' matches the tool configuration name

    }

    stages {
        //stage('SonarQube Analysis') {
        //    steps {
        //        withSonarQubeEnv('SonarQube') { // Replace 'SonarQube' with your SonarQube server name
                    // Use double quotes around the path to handle spaces
        //            sh "\"$SCANNER_HOME/bin/sonar-scanner.bat\""
        //        }
        //    }
        //}

        stage('Dependency Scanning (Snyk)') {
            steps {
                echo 'Testing...'
                snykSecurity(
                snykInstallation: 'Snyk',
                //snykTokenId: "${env.SNYK_TOKEN}", // Access environment variable
                snykTokenId: "cf8415a3-1d6b-4d81-be96-b3451d1675b0"
                // place other parameters here
                )
            }
        }
    }
}
