
php artisan make:model Centre -mcr

php artisan make:model Exam -mcr

php artisan make:model ExamSession -mcr

php artisan make:model Competency -mcr

php artisan make:model CcpWeight -mcr

php artisan make:model Candidate -mcr

php artisan make:model CandidateDocument -mcr

php artisan make:model Score -mcr

php artisan make:model Result -mcr

php artisan make:model PvSignature -mcr

php artisan make:model AuditLog -mcr

php artisan make:model Notification -mcr

php artisan make:controller Admin/UserController --resource

php artisan make:model Role -mcr
php artisan make:factory CentreFactory --model=Centre
php artisan make:factory ExamFactory --model=Exam
php artisan make:factory ExamSessionFactory --model=ExamSession
php artisan make:factory CompetencyFactory --model=Competency
php artisan make:factory CcpWeightFactory --model=CcpWeight
php artisan make:factory CandidateFactory --model=Candidate
php artisan make:factory CandidateDocumentFactory --model=CandidateDocument
php artisan make:factory ScoreFactory --model=Score
php artisan make:factory ResultFactory --model=Result
php artisan make:factory PvSignatureFactory --model=PvSignature
php artisan make:factory AuditLogFactory --model=AuditLog
php artisan make:factory NotificationFactory --model=Notification
php artisan make:factory RoleFactory --model=Role




php artisan migrate:refresh --path=/database/migrations/2025_10_07_215834_create_exam_sessions_table.php
php artisan migrate:refresh --path=/database/migrations/2025_10_07_215837_create_scores_table.php
php artisan migrate:refresh --path=/database/migrations/2025_10_07_215835_create_competencies_table.php
php artisan migrate:refresh --path=/database/migrations/
php artisan migrate:refresh --path=/database/migrations/
php artisan migrate:refresh --path=/database/migrations/
php artisan migrate:refresh --path=/database/migrations/
