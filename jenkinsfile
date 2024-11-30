pipeline {
    agent {
        label any // Replace 'your-node-label' with the label of your Jenkins agent
    }

    stages {
        stage('SonarQube Analysis') {
            steps {
                withSonarQubeEnv('SonarQube') { // Replace 'SonarQube' with the name of your configured SonarQube server
                    //bat 'sonar-scanner.bat -D"sonar.projectKey=docApp1" -D"sonar.sources=." -D"sonar.host.url=http://localhost:9000" -D"sonar.token=sqp_708ff3cba6d49038ad07bed08ae55763819b99da"'
                }
            }
        }

       
    }

}
