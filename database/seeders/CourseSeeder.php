<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseCourseCategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #TODO Course source in course_source table with foreign key.
        // $courses =  array(
        //   array(
        //       'name' => "AMR-competency",
        //       "description" => "",
        //       "credit_hours" => 8,
        //       "source" => "Open WHO",
        //       "url" => "https://openwho.org/courses/AMR-competency",
        //       "due_date" => null,
        //       "course_categories" => ["Antimicrobial Resistance Channel"],
        //       "is_approved" => 1
        //   ),
        //   array(
        //     'name' => "RCCE-COVID-19",
        //     "description" => "",
        //     "credit_hours" => 2,
        //     "source" => "Open WHO",
        //     "url" => "https://openwho.org/courses/RCCE-COVID-19",
        //     "due_date" => null,
        //     "course_categories" => ["Risk Communication", "WHO Mandatory Trainings"],
        //     "is_approved" => 1
        //   ),
        //   array(
        //     'name' => "Data Analysis and Data Vizualization",
        //     "description" => "",
        //     "credit_hours" => 8,
        //     "source" => "iLearn",
        //     "url" => "https://who.csod.com/ui/lms-learning-details/app/course/ac716a33-6379-5a22-88e9-37c574c06106",
        //     "due_date" => null,
        //     "course_categories" => ["Data Analysis and Data Vizualization", "WHO Mandatory Trainings"],
        //     "is_approved" => 1
        //   ),
        // );

        $courses = [
            ['name'=> "AMR Competency",'source' => 'Open WHO','course_categories' =>['Antimicrobial Resistance Channel'],'url' => 'https://openwho.org/courses/AMR-competency ','credit_hours' =>8,"description" => "","due_date" => null,"is_approved" => 1,
             ],
            ['name'=> "Anaphylaxis",'source' => 'Open WHO','course_categories' =>['Clinical Management Channel - OPTIONAL'],'url' => 'https://openwho.org/courses/anaphylaxis','credit_hours' =>0.34,"description" => "","due_date" => null,"is_approved" => 1,
             ],
            ['name'=> "Severe Acute Respiratory Infection",'source' => 'Open WHO','course_categories' =>['Clinical Management Channel - OPTIONAL'],'url' => 'https://openwho.org/courses/severe-acute-respiratory-infection','credit_hours' =>10,"description" => "","due_date" => null,"is_approved" => 1,
            ],
            ['name'=> "Clinical Management COVID-19: Mild, Moderate, Severe",
                'source' => 'Open WHO','course_categories' =>['Clinical Management Channel - OPTIONAL'],'url' => 'https://openwho.org/courses/clinical-management-COVID-19-mild-mod-severe','credit_hours' =>3,"description" => "","due_date" => null,"is_approved" => 1,
                ],
            ['name'=> "Clinical Management COVID-19: Initial Approach",
                'source' => 'Open WHO','course_categories' =>['Clinical Management Channel - OPTIONAL'],'url' => 'https://openwho.org/courses/clinical-management-COVID-19-initial-approach','credit_hours' =>6,"description" => "","due_date" => null,"is_approved" => 1,
                 ],
            ['name'=>  "Clinical Management COVID-19: Rehabilitation",
                'source' => 'Open WHO','course_categories' =>['Clinical Management Channel - OPTIONAL'],'url' => 'https://openwho.org/courses/clinical-management-COVID-19-rehabilitation','credit_hours' =>3,"description" => "","due_date" => null,"is_approved" => 1,
                  ],
            ['name'=> "Clinical Management COVID-19: General Considerations",
                'source' => 'Open WHO','course_categories' =>['Clinical Management Channel - OPTIONAL'],'url' => 'https://openwho.org/courses/clinical-management-COVID-19-general-considerations','credit_hours' => 3,"description" => "","due_date" => null,"is_approved" => 1,
                  ],
            ['name'=> "Clinical Management COVID-19: Case Management",
                'source' => 'Open WHO','course_categories' =>['Clinical Management Channel - OPTIONAL'],'url' => 'https://openwho.org/courses/seasonal-influenza-clinical-management','credit_hours' => 4,"description" => "","due_date" => null,"is_approved" => 1,
                  ],
            ['name'=> "RCCE COVID-19",
                'source' => 'Open WHO','course_categories' =>['Risk Communication'],'url' => 'https://openwho.org/courses/RCCE-COVID-19','credit_hours' =>2,"description" => "","due_date" => null,"is_approved" => 1,
                  ],
            ['name'=> "Infodemic Management 101",
                'source' => 'Open WHO','course_categories' =>['Risk Communication'],'url' => 'https://openwho.org/courses/infodemic-management-101','credit_hours' =>4,"description" => "","due_date" => null,"is_approved" => 1,
                  ],
            ['name'=> "Risk Communication Essentials",
                'source' => 'Open WHO','course_categories' =>['Risk Communication'],'url' => 'https://openwho.org/courses/risk-communication','credit_hours' =>8,"description" => "","due_date" => null,"is_approved" => 1,
                 ],
            ['name'=> "Key considerations for SARS-CoV-2 antigen RDT implementation",
                'source' => 'Open WHO','course_categories' =>['Lab-related'],'url' => 'https://openwho.org/courses/SARS-CoV-2-Ag-RDT-implementation','credit_hours' => 2,"description" => "","due_date" => null,"is_approved" => 1,
                 ],
            ['name'=> "SARS-CoV-2 Ag RDT",
                'source' => 'Open WHO','course_categories' =>['Lab-related'],'url' => 'https://openwho.org/courses/SARS-CoV-2-Ag-RDT','credit_hours' =>2.5,"description" => "","due_date" => null,"is_approved" => 1,
                 ],
            ['name'=> "IPC leadership EN",
                'source' => 'Open WHO','course_categories' =>['Infection Prevention and Control Channel'],'url' => 'https://openwho.org/courses/IPC-leadership-EN','credit_hours' =>4,"description" => "","due_date" => null,"is_approved" => 1,
                 ],
            ['name'=> "IPC CC MMIS EN",
                'source' => 'Open WHO','course_categories' =>['Infection Prevention and Control Channel'],'url' => 'https://openwho.org/courses/IPC-CC-MMIS-EN','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
                  ],
            ['source' => 'Open WHO','course_categories' =>['Infection Prevention and Control Channel'],'url' => 'https://openwho.org/courses/IPC-SP-PPE-EN','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' =>  "IPC SP PPE EN" ],
            ['source' => 'Open WHO','course_categories' =>['Infection Prevention and Control Channel'],'url' => 'https://openwho.org/courses/IPC-PPE-EN','credit_hours' =>0.25,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "IPC PPE EN" ],
            ['source' => 'Open WHO','course_categories' =>['Infection Prevention and Control Channel'],'url' => 'https://openwho.org/courses/ipc-health-workers','credit_hours' => 1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "IPC Health Workers" ],
            ['source' => 'Open WHO','course_categories' =>['Infection Prevention and Control Channel'],'url' => 'https://openwho.org/courses/IPC-TBP-EN','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "IPC TBP EN" ],
            ['source' => 'Open WHO','course_categories' =>['Infection Prevention and Control Channel'],'url' => 'https://openwho.org/courses/COVID-19-and-work','credit_hours' =>2,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "COVID-19 and work" ],
            ['source' => 'Open WHO','course_categories' =>['Infection Prevention and Control Channel'],'url' => 'https://openwho.org/courses/COVID-19-IPC-EN','credit_hours' => 1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "COVID-19 IPC EN" ],
            ['source' => 'Open WHO','course_categories' =>['Infection Prevention and Control Channel'],'url' => 'https://openwho.org/courses/COVID-19-occupational-health-and-safety','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "COVID-19 occupational health and safety" ],
            ['source' => 'Open WHO','course_categories' =>['Infection Prevention and Control Channel'],'url' => 'https://openwho.org/courses/IPC-HH-en','credit_hours' => 1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "IPC HH en" ],
            ['source' => 'Open WHO','course_categories' =>['Infection Prevention and Control Channel'],'url' => 'https://openwho.org/courses/IPC-WM-EN','credit_hours' => 1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "IPC WM EN" ],
            ['source' => 'Open WHO','course_categories' =>['Infection Prevention and Control Channel'],'url' => 'https://openwho.org/courses/IPC-EC-EN','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "IPC EC EN" ],
            ['source' => 'Open WHO','course_categories' =>['One Health Channel'],'url' => 'https://openwho.org/courses/human-animal-health-sectors ','credit_hours' =>2,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Human animal health sectors"],
            ['source' => 'Open WHO','course_categories' =>['One Health Channel'],'url' => 'https://openwho.org/courses/one-health-joint-risk-assessment','credit_hours' =>2,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "One Health Joint Risk Assessment"],
            ['source' => 'Open WHO','course_categories' =>['Outbreak Channel'],'url' => 'https://openwho.org/courses/public-health-interventions','credit_hours' =>3,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Public Health Interventions"],
            ['source' => 'Open WHO','course_categories' =>['Outbreak Channel'],'url' => 'https://openwho.org/courses/pandemic-epidemic-diseases','credit_hours' =>6,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Pandemic Epidemic Diseases"],
            ['source' => 'Open WHO','course_categories' =>['Outbreak Channel'],'url' => 'https://openwho.org/courses/cholera-introduction-en','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Cholera Introduction"],
            ['source' => 'Open WHO','course_categories' =>['COVID-19 related'],'url' => 'https://openwho.org/courses/covid-19-intra-action-review-en','credit_hours' => 2,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "COVID-19 Intra Action Review"],
            ['source' => 'Open WHO','course_categories' =>['COVID-19 related'],'url' => 'https://openwho.org/courses/introduction-to-ncov','credit_hours' =>3,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Introduction to NCOV"],
            ['source' => 'Open WHO','course_categories' =>['COVID-19 related'],'url' => 'https://openwho.org/courses/eprotect-acute-respiratory-infections','credit_hours' =>2,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Eprotect Acute Respiratory Infections"],
            ['source' => 'Open WHO','course_categories' =>['COVID-19 related'],'url' => 'https://openwho.org/courses/UNCT-COVID19-preparedness-and-response-EN','credit_hours' =>2,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "UNCT COVID19 Preparedness and Response"],
            ['source' => 'Open WHO','course_categories' =>['COVID-19 related'],'url' => 'COVID-19 Vaccines (openwho.org)','credit_hours' => null,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "COVID-19 Vaccines"],
            ['source' => 'Open WHO','course_categories' =>['OSL'],'url' => 'https://openwho.org/courses/SARI-facilities','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "SARI facilities"],
            ['source' => 'Open WHO','course_categories' =>['OSL'],'url' => 'https://openwho.org/courses/cholera-kits ','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Cholera kits"],
            ['source' => 'Open WHO','course_categories' =>['Preparing for Pandemics Channel'],'url' => 'https://openwho.org/courses/influenza-prevention-control','credit_hours' =>0.5,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' => "Influenza Prevention Control" ],
            ['source' => 'Open WHO','course_categories' =>['Preparing for Pandemics Channel'],'url' => 'https://openwho.org/courses/influenza-sentinel-surveillance','credit_hours' =>14,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' => "Influenza Sentinel Surveillance" ],
            ['source' => 'Open WHO','course_categories' =>['Preparing for Pandemics Channel'],'url' => 'https://openwho.org/courses/avian-and-other-zoonotic-influenza-introduction ','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' => "Avian and other zoonotic influenza introduction" ],
            ['source' => 'Open WHO','course_categories' =>['Ready for Response Channel'],'url' => 'https://openwho.org/courses/covid-19-intra-action-review-en','credit_hours' =>2,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' => "COVID-19 Intra Action Review" ],
            ['source' => 'Open WHO','course_categories' =>['Ready for Response Channel'],'url' => 'https://openwho.org/courses/WHO-COVID-19-mass-gatherings-risk-assessment-training','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' =>  "WHO COVID-19 mass gatherings risk assessment training" ],
            ['source' => 'Open WHO','course_categories' =>['Ready for Response Channel'],'url' => 'https://openwho.org/courses/hedrm-in-cities','credit_hours' =>1.5,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' => "HEDRM in cities" ],
            ['source' => 'Open WHO','course_categories' =>['Ready for Response Channel'],'url' => 'https://openwho.org/courses/SOPs-for-emergencies','credit_hours' =>6.5,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' => "SOPs for emergencies" ],
            ['source' => 'Open WHO','course_categories' =>['Ready for Response Channel'],'url' => 'https://openwho.org/courses/ready4response-tier1-EN','credit_hours' =>7,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' => "Ready4response Tier1" ],
            ['source' => 'Open WHO','course_categories' =>['Ready for Response Channel'],'url' => 'https://openwho.org/courses/PHEOC-EN','credit_hours' =>3,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' => "PHEOC" ],
            ['source' => 'Open WHO','course_categories' =>['Ready for Response Channel'],'url' => 'https://openwho.org/courses/health-cluster','credit_hours' =>9,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' => "Health Cluster" ],
            ['source' => 'Open WHO','course_categories' =>['Ready for Response Channel'],'url' => 'https://openwho.org/courses/incident-management-system','credit_hours' =>3,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' => "Incident Management System" ],
            ['source' => 'Open WHO','course_categories' =>['Ready for Response Channel'],'url' => 'https://openwho.org/courses/incident-management-system-tier2','credit_hours' =>3,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' => "Incident Management System Tier2" ],
            ['source' => 'Open WHO','course_categories' =>['Ready for Response Channel'],'url' => 'https://openwho.org/courses/operational-readiness-introduction','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' => "Operational Readiness Introduction" ],
            ['source' => 'Open WHO','course_categories' =>['Ready for Response Channel'],'url' => 'https://openwho.org/courses/simex','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' => "Simex" ],
            ['source' => 'Open WHO','course_categories' =>['Ready for Response Channel'],'url' => 'https://openwho.org/courses/AAR-en','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
                 'name' => "AAR" ],
            ['source' => 'iLearn','course_categories' =>[],'url' => 'ePMDS+ Performance Management Cycle in WHO (csod.com)','credit_hours' =>0.75,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "ePMDS+ Performance Management Cycle in WHO" ],
            ['source' => 'iLearn','course_categories' =>[],'url' => 'Fleet Management for Drivers 3.0 (csod.com)','credit_hours' =>2,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Fleet Management for Drivers 3.0" ],
            ['source' => 'iLearn','course_categories' =>['Risk Management'],'url' => 'Module 1: Fundamentals of Risk Management (csod.com)','credit_hours' =>0.75,"description" => "","due_date" => null,"is_approved" => 1,
             'name' =>  "Module 1: Fundamentals of Risk Management"],
            ['source' => 'iLearn','course_categories' =>['Risk Management'],'url' => 'Module 2: Implementing Risk Management (csod.com)','credit_hours' =>0.5,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Module 2: Implementing Risk Management" ],
            ['source' => 'iLearn','course_categories' =>['Risk Management'],'url' => 'Module 3: Using the Risk Management Tool (csod.com)','credit_hours' =>0.6,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Module 3: Using the Risk Management Tool" ],
            ['source' => 'iLearn','course_categories' =>[],'url' => 'Understand how work flows in GSM (csod.com)','credit_hours' =>0.27,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Understand how work flows in GSM" ],
            ['source' => 'iLearn','course_categories' =>[],'url' => 'Health Cluster Coordination (csod.com)','credit_hours' =>9,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Health Cluster Coordination" ],
            ['source' => 'iLearn','course_categories' =>['COVID-19 '],'url' => 'Infection Prevention and Control (IPC) for Novel Coronavirus (COVID-19) (csod.com)','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Infection Prevention and Control (IPC) for Novel Coronavirus (COVID-19)" ],
            ['source' => 'iLearn','course_categories' =>['COVID-19'],'url' => 'Building resilience during intense change and uncertainty due to COVID-19 pandemic (csod.com)','credit_hours' =>1.5,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Building resilience during intense change and uncertainty due to COVID-19 pandemic" ],
            ['source' => 'iLearn','course_categories' =>['COVID-19'],'url' => 'Fighting COVID-19 with Epidemiology: A Johns Hopkins Teach-Out | Coursera (csod.com)','credit_hours' =>5,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Fighting COVID-19 with Epidemiology: A Johns Hopkins Teach-Out | Coursera" ],
            ['source' => 'iLearn','course_categories' =>['Data Analysis and Data Vizualization'],'url' => 'Power BI Essential Training (csod.com)','credit_hours' =>3.5,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Power BI Essential Training" ],
            ['source' => 'iLearn','course_categories' =>['Data Analysis and Data Vizualization'],'url' => 'Power BI: Dashboards for Beginners (csod.com)','credit_hours' =>0.5,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Power BI: Dashboards for Beginners" ],
            ['source' => 'iLearn','course_categories' =>['Data Analysis and Data Vizualization'],'url' => 'CompTIA Data+ (DA0-001) Cert Prep: Data Mining (csod.com)','credit_hours' =>1.5,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "CompTIA Data+ (DA0-001) Cert Prep: Data Mining" ],
            ['source' => 'iLearn','course_categories' =>['Data Analysis and Data Vizualization'],'url' => 'Learning Excel: Data-Analysis (csod.com)','credit_hours' =>0.48,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Learning Excel: Data-Analysis" ],
            ['source' => 'iLearn','course_categories' =>['Data Analysis and Data Vizualization'],'url' => 'Data-Driven Learning Design (csod.com)','credit_hours' =>0.43,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Data-Driven Learning Design" ],
            ['source' => 'iLearn','course_categories' =>['Data Analysis and Data Vizualization'],'url' => 'Data Visualization: Storytelling (csod.com)','credit_hours' =>1.5,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Data Visualization: Storytelling" ],
            ['source' => 'iLearn','course_categories' =>['Data Analysis and Data Vizualization'],'url' => 'Data Visualization: Best Practices (csod.com)','credit_hours' =>1.5,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Data Visualization: Best Practices" ],
            ['source' => 'iLearn','course_categories' =>['Data Analysis and Data Vizualization'],'url' => 'Python for Data Visualization (csod.com)','credit_hours' =>1.5,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Python for Data Visualization" ],
            ['source' => 'iLearn','course_categories' =>['Data Analysis and Data Vizualization'],'url' => 'The Data Science of Healthcare, Medicine, and Public Health, with Barton Poulson (csod.com)','credit_hours' =>1.25,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "The Data Science of Healthcare, Medicine, and Public Health, with Barton Poulson" ],
            ['source' => 'iLearn','course_categories' =>['Data Analysis and Data Vizualization'],'url' => 'Using Public Health Dashboards (csod.com)','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Using Public Health Dashboards" ],
            ['source' => 'iLearn','course_categories' =>['Data Analysis and Data Vizualization'],'url' => 'MySQL Essential Training (csod.com)','credit_hours' =>2,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "MySQL Essential Training" ],
            ['source' => 'iLearn','course_categories' =>['Data Analysis and Data Vizualization'],'url' => 'SQL: Data Reporting and Analysis - 2020 Revision (csod.com)','credit_hours' =>2.25,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "SQL: Data Reporting and Analysis - 2020 Revision" ],
            ['source' => 'iLearn','course_categories' =>['Data Analysis and Data Vizualization'],'url' => 'Excel: Creating a Basic Dashboard (csod.com)','credit_hours' =>1.5,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Excel: Creating a Basic Dashboard" ],
            ['source' => 'iLearn','course_categories' =>['Data Skills'],'url' => 'Intermediate Skills in Microsoft® Access® 2010 (1 hour) (csod.com)','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Intermediate Skills in Microsoft® Access® 2010" ],
            ['source' => 'iLearn','course_categories' =>['Data Skills'],'url' => 'Excel 2016 advanced (part of Synergy10) (csod.com)','credit_hours' =>2.5,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Excel 2016 advanced" ],
            ['source' => 'iLearn','course_categories' =>['Data Skills'],'url' => 'Data Ethics: Making Data-Driven Decisions (csod.com)','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Data Ethics: Making Data-Driven Decisions" ],
            ['source' => 'iLearn','course_categories' =>['Data Skills'],'url' => 'CompTIA Data+ (DA0-001) Cert Prep: Data Governance, Quality, and Controls (csod.com)','credit_hours' =>1.5,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "CompTIA Data+ (DA0-001) Cert Prep: Data Governance, Quality, and Controls" ],
            ['source' => 'iLearn','course_categories' =>['Data Skills'],'url' => 'Database Foundations: Data Structures (csod.com)','credit_hours' =>3,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Database Foundations: Data Structures" ],
            ['source' => 'iLearn','course_categories' =>['Information Management '],'url' => 'Information Management: Document Security (csod.com) ','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Information Management: Document Security" ],
            ['source' => 'iLearn','course_categories' =>['Information Management '],'url' => 'Free Health Information Management Certificates | POLHN (csod.com)','credit_hours' =>5,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Free Health Information Management Certificates" ],
            ['source' => 'iLearn','course_categories' =>['WHO Mandatory Trainings'],'url' => 'Welcome to WHO (csod.com)','credit_hours' =>0.25,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Welcome to WHO" ],
            ['source' => 'iLearn','course_categories' =>['WHO Mandatory Trainings'],'url' => 'Prevention of sexual exploitation and abuse (PSEA) - Multilanguage (2021) (csod.com)','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Prevention of sexual exploitation and abuse" ],
            ['source' => 'iLearn','course_categories' =>['WHO Mandatory Trainings'],'url' => 'UN BSAFE (English/French) 1 hour (csod.com)','credit_hours' =>1,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "UN BSAFE" ],
            ['source' => 'iLearn','course_categories' =>['WHO Mandatory Trainings'],'url' => 'Cybersecurity Essentials & Preventing Phishing PLUS Cybersecurity Refresher.','credit_hours' => null,"description" => "","due_date" => null,"is_approved" => 1,
             'name' =>  "Cybersecurity Essentials & Preventing Phishing PLUS Cybersecurity Refresher" ],
            ['source' => 'iLearn','course_categories' =>['WHO Mandatory Trainings'],'url' => 'WHO United to Respect (expected to be rolled out soon)','credit_hours' => null,"description" => "","due_date" => null,"is_approved" => 1,
             'name' =>  "WHO United to Respect"],
            ['source' => 'Health Security Learning Platform','course_categories' =>[],'url' => 'Introduction to the IHR','credit_hours' => null,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Introduction to the IHR"],
            ['source' => 'Health Security Learning Platform','course_categories' =>[],'url' => 'Introduction to IHR Monitoring & Evaluation Framework','credit_hours' =>3,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Introduction to IHR Monitoring & Evaluation Framework"],
            ['source' => 'Health Security Learning Platform','course_categories' =>[],'url' => 'One Health - Multisectoral collaboration at the Human, Animal, Environment Interface','credit_hours' =>4,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "One Health - Multisectoral collaboration at the Human, Animal, Environment Interface"],
            ['source' => 'Health Security Learning Platform','course_categories' =>[],'url' => 'Ship Sanitation Certificate','credit_hours' =>20,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Ship Sanitation Certificate"],
            ['source' => 'Health Security Learning Platform','course_categories' =>[],'url' => 'Lab Quality Management System Basics','credit_hours' =>3,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Lab Quality Management System Basics"],
            ['source' => 'Health Security Learning Platform','course_categories' =>[],'url' => 'Event Management at Points of Entry','credit_hours' => null,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Event Management at Points of Entry"],
            ['source' => 'Health Security Learning Platform','course_categories' =>[],'url' => 'IDSR','credit_hours' => null,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "IDSR" ],
            ['source' => 'Health Security Learning Platform','course_categories' =>[],'url' => 'Public Health Preparedness for Mass Gathering Events','credit_hours' =>6,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Public Health Preparedness for Mass Gathering Events" ],
            ['source' => 'Health Security Learning Platform','course_categories' =>[],'url' => 'Public Health Event Management in Air Transport','credit_hours' =>4,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Public Health Event Management in Air Transport" ],
            ['source' => 'Open WHO','course_categories' =>[],'url' => 'WHO Policy Guidance on Integrated Antimicrobial Stewardship Activities','credit_hours' => null,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "WHO Policy Guidance on Integrated Antimicrobial Stewardship Activities" ],
            ['source' => 'Open WHO','course_categories' =>[],'url' => 'Antimicrobial stewardship programmes in health-care facilities in low- and middle-income countries: a WHO practical toolkit','credit_hours' => null,"description" => "","due_date" => null,"is_approved" => 1,
             'name' => "Antimicrobial stewardship programmes in health-care facilities in low- and middle-income countries: a WHO practical toolkit" ],
        ];



        foreach ($courses as $course) {
            $createdCourse = Course::create(
                [
                  'name' => $course['name'],
                  'description' => $course['description'],
                  'credit_hours' => $course['credit_hours'],
                  'source' => $course['source'],
                  'url' => $course['url'],
                  'due_date' => $course['due_date'],
                  'is_approved' => $course['is_approved']
                ]
            );
            // $user1 = User::where('email', 'normaluser@who.int')->first();
            // $user2 = User::where('email', 'supervisor@who.int')->first();
            if (isset($course['course_categories'])) {
                foreach ($course['course_categories'] as $courseCategory) {
                    $courseCategoryId = CourseCategory::where(DB::raw('lower(name)'), strtolower($courseCategory))
                    ->pluck('id')->first();
                    CourseCourseCategory::create([
                        "course_id" => $createdCourse->id,
                        "course_category_id" => $courseCategoryId
                    ]);
                }
            }


            // $user1->courses()->attach($createdCourse->id);
            // $user2->courses()->attach($createdCourse->id);
        }
    }
}
