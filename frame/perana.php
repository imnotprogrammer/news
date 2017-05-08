<?php
/**
 * Perana
 * 性能分析助手
 * 
 * @package   
 * @author  lht
 * @version 2015/11/13
 * @access public
 */
class Perana{
    
    static $enable = true;
    static $startTime;
    static $file = '/var/netmoon/nms_log';
    static $times = [];
    static $mode = 1;
    
    /**
     * Perana::time()
     * 开始计时
     * @param string $key  标记值，开始和结束的标记值要一样。 
     * @param string $desc 备注信息
     * @return
     */
    static function time($key,$desc=""){
        
        if( !$key ){
            return false;
        }
        
        self::$times[$key][] = [ 
            's' => microtime(true),
            'd' => $desc 
        ];
    }
    
    /**
     * Perana::timeEnd()
     * 结束计时
     * @param string $key  标记值，开始和结束的标记值要一样。 
     * @return
     */
    static function timeEnd($key){
        
        if( !$key ){
            return false;
        }
        
        $count = count(self::$times[$key]);
        
        if( isset(self::$times[$key][$count-1]) ){
            $time = microtime(true);
            $runTime = $time - self::$times[$count-1]['s'];
            $runTime = number_format($runTime,4,'.','');
            if( empty($runTime) ){
                $runTime = 0;
            }
            self::$times[$key][$count-1]['r'] = $runTime;
        } 
        
    }
    
    /**
     * Perana::record()
     * 记录时间
     * 可以采用 register_shutdown_function('Perana::record');在结束脚本时，记录数据。
     * 
     * @return
     */
    static function record(){
        
        $times = self::$times;
        
        if( empty($times) || !self::$enable ){
            return false;
        }
        
        $strs = [];
        
        if( self::$mode == 0 ){
            
            return false;
            
        }elseif( self::$mode == 1 ){
            
            foreach( $times as $key=>$ktimes ){
                foreach( $ktimes as $ktime ){
                    $ktime['k'] = $key;
                    $ktime = [
                        $ktime['s'],
                        $ktime['r'],
                        $ktime['k'],
                        $ktime['d']
                    ];
                    $strs[] = json_encode($ktime,JSON_UNESCAPED_UNICODE);
                }
            }
            
            $str = implode(PHP_EOL,$strs) . PHP_EOL;
            
            $fd = fopen(self::$file . '/perana_sdf23d4.log','a');
            
            fwrite($fd,$str);
            
            fclose($fd);
        
        }elseif( self::$mode == 2 ){
            
            foreach( $times as $key=>$ktimes ){
                
                foreach( $ktimes as $ktime ){
                    $ktime = [
                        $ktime['s'],
                        $ktime['r'],
                        $ktime['d']
                    ];
                    $strs[] = json_encode($ktime,JSON_UNESCAPED_UNICODE);
                }
                
                $str = implode(PHP_EOL,$strs) . PHP_EOL;
                
                
            
                $fd = fopen(self::$file . '/perana_' . str_replace('/','_',$key),'a');
                
                fwrite($fd,$str);
                
                fclose($fd);
                
            }
            
        }
        
    }
    
    /**
     * Perana::recordRunTime()
     * 记录运行时间
     * 
     * @param string $key 标记值
     * @param float $start 起始时间 通过microtime(true)获取
     * @param mixed $end 结束时间 通过microtime(true)获取
     * @param string $desc 备注信息
     * @return
     */
    static function recordRunTime($key,$start,$end,$desc=""){
    
        $count = count(self::$times[$key]);
        $runTime = $end-$start;
        $runTime = number_format($runTime,4,'.','');
        if( empty($runTime) ){
            $runTime = 0;
        }
        self::$times[$key][$count] = [
            's'=>$start,
            'k'=>$key,
            'r'=>$runTime,
            'd'=>$desc
        ];
        
    }
    
    /**
     * Perana::peak_mem_cpu()
     * 记录内存使用峰值，cpu使用情况
     * 
     * @param array $cpuMark  cpu标记值  通过getrusage()获取
     * @param float $timeStartMark 起始时间记录值
     * @param float $timeEndMark 停止时间记录值
     * @return
     */
    static function peak_mem_cpu($cpuMark,$timeStartMark,$timeEndMark){
        
        $mem = 0;
        $cpu = [];
        
        $rtime = $timeEndMark - $timeStartMark;
        
        if( function_exists('memory_get_peak_usage')  ){
            $mem = memory_get_peak_usage()/1024/1024;
            $mem = number_format($mem,3,'.','');
        }
        
        if( function_exists('getrusage') ){
            
            $ru = getrusage();
            $cpu['time'] = 0;
            $cpu = [
                'stime'=>$ru['ru_stime.tv_sec'] + $ru['ru_stime.tv_usec'] /1000000 - $cpuMark['ru_stime.tv_sec'] - $cpuMark['ru_stime.tv_usec'] / 1000000,
                'utime'=>$ru['ru_utime.tv_sec'] + $ru['ru_utime.tv_usec'] /1000000 - $cpuMark['ru_utime.tv_sec'] - $cpuMark['ru_utime.tv_usec'] / 1000000,
            ];
            $cpu['time'] = $cpu['stime'] + $cpu['utime'];
            $cpu['rate'] = $cpu['time'] / $rtime;
            
            foreach( $cpu as $key=>$v ){
                $cpu[$key] = number_format($v,4,'.','');
            }
            
        }
        
        $data = [
            'ctime'=>time(),
            'mem'=>[
                'peak'=>$mem
            ],
            'cpu'=>$cpu,
            'rtime'=>$rtime
        ];
        
        $fd = fopen(self::$file . '/peak_mem_cpu','a');
        
        fwrite($fd,json_encode($data) . PHP_EOL);
        
        fclose($fd);
        
    }
    
}

register_shutdown_function('Perana::record');