import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:mobile_scanner/mobile_scanner.dart';
import 'core/constants/app_colors.dart';
import 'core/constants/app_strings.dart';
import 'passport_tracking_screen.dart';

class PassportInquiryScreen extends StatefulWidget {
  const PassportInquiryScreen({super.key});

  @override
  State<PassportInquiryScreen> createState() => _PassportInquiryScreenState();
}

class _PassportInquiryScreenState extends State<PassportInquiryScreen> {
  final TextEditingController _serialNumberController = TextEditingController();

  @override
  void dispose() {
    _serialNumberController.dispose();
    super.dispose();
  }

  Future<void> _scanBarcode() async {
    try {
      final String? result = await Navigator.push<String>(
        context,
        MaterialPageRoute(builder: (context) => const _BarcodeScannerScreen()),
      );
      if (result != null && result.isNotEmpty) {
        setState(() {
          _serialNumberController.text = result;
        });
      }
    } catch (e) {
      debugPrint("Failed to scan barcode: $e");
    }
  }

  void _showHelpDialog() {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return Directionality(
          textDirection: TextDirection.rtl,
          child: AlertDialog(
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12),
            ),
            title: Text(
              "مكان الرقم التسلسلي",
              style: GoogleFonts.cairo(
                color: AppColors.primaryDarkBlue,
                fontWeight: FontWeight.bold,
              ),
            ),
            content: Column(
              mainAxisSize: MainAxisSize.min,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  "يمكنك العثور على الرقم التسلسلي الطويل في أعلى يمين إيصال معاملة الجواز الخاص بك الممنوح لك من مصلحة الهجرة والجوازات.",
                  style: GoogleFonts.cairo(
                    color: AppColors.textGreyLight,
                    fontSize: 14,
                  ),
                ),
              ],
            ),
            actions: [
              TextButton(
                onPressed: () {
                  Navigator.pop(context);
                },
                child: Text(
                  "حسناً",
                  style: GoogleFonts.cairo(
                    color: AppColors.primaryDarkBlue,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ),
            ],
          ),
        );
      },
    );
  }

  void _handleInquiry() {
    if (_serialNumberController.text.trim().isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(
            "يرجى إدخال الرقم التسلسلي أولاً",
            style: GoogleFonts.cairo(),
          ),
          backgroundColor: Colors.redAccent,
          behavior: SnackBarBehavior.floating,
        ),
      );
      return;
    }

    Navigator.push(
      context,
      MaterialPageRoute(builder: (context) => const PassportTrackingScreen()),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.white,
      body: SafeArea(
        child: Directionality(
          textDirection: TextDirection.rtl,
          child: LayoutBuilder(
            builder: (context, constraints) {
              return SingleChildScrollView(
                physics: const BouncingScrollPhysics(),
                child: ConstrainedBox(
                  constraints: BoxConstraints(minHeight: constraints.maxHeight),
                  child: IntrinsicHeight(
                    child: Padding(
                      padding: const EdgeInsets.symmetric(horizontal: 24.0),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.stretch,
                        children: [
                          // 1. Top Logo
                          Padding(
                            padding: const EdgeInsets.only(
                              top: 60.0,
                              bottom: 24.0,
                            ),
                            child: Image.asset(
                              'assets/logo.png',
                              height: 140,
                              fit: BoxFit.contain,
                            ),
                          ),

                          // 2. Header Section
                          Text(
                            AppStrings.inquiryTitle,
                            textAlign: TextAlign.center,
                            style: GoogleFonts.cairo(
                              color: AppColors.primaryDarkBlue,
                              fontWeight: FontWeight.bold,
                              fontSize: 24,
                            ),
                          ),
                          const SizedBox(height: 8),
                          Text(
                            AppStrings.inquirySubtitle,
                            textAlign: TextAlign.center,
                            style: GoogleFonts.cairo(
                              color: AppColors.textGreyLight,
                              fontWeight: FontWeight.w400,
                              fontSize: 14,
                            ),
                          ),
                          const SizedBox(height: 40),

                          // 3. Input Section (Serial Number)
                          Text(
                            AppStrings.serialNumberLabel,
                            textAlign: TextAlign.start,
                            style: GoogleFonts.cairo(
                              color: AppColors.primaryDarkBlue,
                              fontWeight: FontWeight.bold,
                              fontSize: 14,
                            ),
                          ),
                          const SizedBox(height: 8),
                          TextFormField(
                            controller: _serialNumberController,
                            style: GoogleFonts.cairo(),
                            decoration: InputDecoration(
                              filled: true,
                              fillColor: AppColors.white,
                              hintText: AppStrings.serialNumberHint,
                              hintStyle: GoogleFonts.cairo(
                                color: AppColors.textGreyLight,
                                fontSize: 14,
                              ),
                              contentPadding: const EdgeInsets.symmetric(
                                horizontal: 16,
                                vertical: 16,
                              ),
                              border: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(10),
                                borderSide: const BorderSide(
                                  color: AppColors.borderLight,
                                ),
                              ),
                              enabledBorder: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(10),
                                borderSide: const BorderSide(
                                  color: AppColors.borderLight,
                                ),
                              ),
                              focusedBorder: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(10),
                                borderSide: const BorderSide(
                                  color: AppColors.primaryDarkBlue,
                                  width: 1.5,
                                ),
                              ),
                              suffixIcon: IconButton(
                                icon: const Icon(
                                  Icons.qr_code_scanner,
                                  color: AppColors.textGreyLight,
                                ),
                                onPressed: _scanBarcode,
                              ),
                            ),
                          ),
                          const SizedBox(height: 24),

                          // 4. Action Button
                          SizedBox(
                            height: 55,
                            width: double.infinity,
                            child: ElevatedButton(
                              onPressed: _handleInquiry,
                              style: ElevatedButton.styleFrom(
                                backgroundColor: AppColors.goldAccent,
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(10),
                                ),
                                elevation: 0,
                              ),
                              child: Row(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: [
                                  const Icon(
                                    Icons.search,
                                    color: AppColors.primaryDarkBlue,
                                  ),
                                  const SizedBox(width: 8),
                                  Text(
                                    AppStrings.searchButton,
                                    style: GoogleFonts.cairo(
                                      color: AppColors.primaryDarkBlue,
                                      fontWeight: FontWeight.bold,
                                      fontSize: 18,
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          ),
                          const SizedBox(height: 24),

                          // 5. Help Link
                          Center(
                            child: InkWell(
                              onTap: _showHelpDialog,
                              borderRadius: BorderRadius.circular(4),
                              child: Padding(
                                padding: const EdgeInsets.all(4.0),
                                child: Row(
                                  mainAxisSize: MainAxisSize.min,
                                  children: [
                                    const Icon(
                                      Icons.help_outline,
                                      color: AppColors.textGreyLight,
                                      size: 16,
                                    ),
                                    const SizedBox(width: 6),
                                    Text(
                                      AppStrings.helpLinkText,
                                      style: GoogleFonts.cairo(
                                        color: AppColors.textGreyLight,
                                        fontSize: 13,
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                            ),
                          ),

                          // Push footer to bottom
                          const Spacer(),
                          const SizedBox(height: 24),

                          // 6. Footer Section
                          Column(
                            children: [
                              const Icon(
                                Icons.verified_user_outlined,
                                color: AppColors.textVeryLightGrey,
                                size: 24,
                              ),
                              const SizedBox(height: 8),
                              Text(
                                AppStrings.republicOfYemen,
                                style: GoogleFonts.cairo(
                                  color: AppColors.textVeryLightGrey,
                                  fontSize: 11,
                                ),
                              ),
                              Text(
                                AppStrings.passportAuthority,
                                style: GoogleFonts.cairo(
                                  color: AppColors.textVeryLightGrey,
                                  fontSize: 11,
                                ),
                              ),
                              const SizedBox(height: 16),
                            ],
                          ),
                        ],
                      ),
                    ),
                  ),
                ),
              );
            },
          ),
        ),
      ),
    );
  }
}

/// A dedicated full-screen barcode scanner screen powered by mobile_scanner.
/// Pops with the scanned string value when a barcode is detected.
class _BarcodeScannerScreen extends StatefulWidget {
  const _BarcodeScannerScreen();

  @override
  State<_BarcodeScannerScreen> createState() => _BarcodeScannerScreenState();
}

class _BarcodeScannerScreenState extends State<_BarcodeScannerScreen> {
  final MobileScannerController _controller = MobileScannerController();
  bool _hasScanned = false;

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Directionality(
      textDirection: TextDirection.rtl,
      child: Scaffold(
        appBar: AppBar(
          title: const Text('مسح الرمز الشريطي'),
          leading: IconButton(
            icon: const Icon(Icons.close),
            onPressed: () => Navigator.pop(context),
          ),
          actions: [
            IconButton(
              icon: const Icon(Icons.flash_on),
              onPressed: () => _controller.toggleTorch(),
            ),
          ],
        ),
        body: Stack(
          children: [
            MobileScanner(
              controller: _controller,
              onDetect: (capture) {
                if (_hasScanned) return;
                final barcodes = capture.barcodes;
                if (barcodes.isNotEmpty) {
                  final String? value = barcodes.first.rawValue;
                  if (value != null) {
                    _hasScanned = true;
                    Navigator.pop(context, value);
                  }
                }
              },
            ),
            // Scanning overlay hint
            Align(
              alignment: Alignment.bottomCenter,
              child: Container(
                padding: const EdgeInsets.all(16),
                margin: const EdgeInsets.only(bottom: 40),
                decoration: BoxDecoration(
                  color: Colors.black54,
                  borderRadius: BorderRadius.circular(8),
                ),
                child: const Text(
                  'وجّه الكاميرا نحو الرمز الشريطي',
                  style: TextStyle(color: Colors.white, fontSize: 14),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
