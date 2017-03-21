<?php namespace Attendance\Models;

use Attendance\Database\AttendanceTable;

/**
 *
 */
class Attendance extends Model
{

    public static function create($pv = [])
    {
        return parent::_create(AttendanceTable::getInstance(), $pv);
    }

    public static function countOf($sub)
    {
        if ($sub == '') {
            return 0;
        }
        $where = sprintf("WHERE reg_no<>'marker' AND subject='%s' AND taken_on LIKE '%s'", $sub, date('Y-m-d') . '%');
        return count(self::select(["*"], $where));
    }

    public static function select($pv = [], $where)
    {
        return parent::_select(AttendanceTable::getInstance(), $pv, $where);
    }
  /**
   * Deletes a matching row from the table
   *
   *  delete(['age' => '=> 12', 'name' =>  '= ram']);
   *
   * @param $wheres array A collection of condition to meet for deleting the record
   *
   * @return boolean true if successfully deleted
   */
    public static function delete($wheres = [])
    {
        return parent::_delete(AttendanceTable::getInstance(), $wheres);
    }
    
    /**
     * Sends the attendance in CSV format for backup.
     */
    public static function sendCSVMail($email, $subject)
    {
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8\r\n";
        $headers .= "From: noreply@gces.edu.np\r\n";
        $headers .= 'X-Mailer: PHP/' . \phpversion();
        $message = 'Here is the backup of the attendance system for your subject "' . $subject . '"';
        $message .= 'Incase the system has lost the database please contact the administrator to import back this backup.';
        $message .= 'With regards,';
        $message .= '  The backup system.';
        $message .= "\r\n---- Initialize backup Comma Separated Value --- \r\n";
        $message .= self::getCSVData($subject);
        $message .= "\r\n---- Complete backup Comma Separated Value --- \r\n";
        return mail($email, 'Daily attendance backup - ' . $subject, $message, $headers);
    }

    public static function backupToCSV()
    {
        $file = DIR_ASST . '/backup.csv';
        $outputFile = fopen($file, 'w+');
        fwrite($outputFile, self::getCSVData(null));
        fclose($outputFile);
        exec('git add ' . $file);
        exec('git commit -m "Update backup"');
        exec('git pull');
        exec('git push');
    }

    private static function getCSVData($subject)
    {
        $attendance;
        if ($subject != null) {
            $attendance = self::select(['*'], "where subject = '$subject'");
        } else {
            $attendance = self::select(['*'], "where id > 0");
        }
        $csv = '';
        foreach ($attendance as $record) {
            foreach ($record as $value) {
                $csv .= '"' . $value . '",';
            }
            $csv = substr($csv, 0, strlen($csv) - 1) . PHP_EOL;
        }
        return $csv;
    }
}
